<?php
session_start();
include 'db.php';

$job_id = isset($_GET['job']) ? intval($_GET['job']) : 0;

// التحقق من الجلسة
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php?redirect=readmore.php?job=" . $job_id);
  exit;
}

// جلب بيانات الوظيفة
$stmt = $conn->prepare("SELECT j.*, c.job AS category, t.name AS type, ci.name AS city, co.name AS country, c.logo 
                        FROM jobs j
                        LEFT JOIN jobs_cat c ON j.job_cat_id = c.id
                        LEFT JOIN jobs_type t ON j.job_type_id = t.id
                        LEFT JOIN cities ci ON j.city_id = ci.id
                        LEFT JOIN countries co ON j.country_id = co.id
                        WHERE j.id = ? AND j.visable = 1");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
  header("Location: 404.php");
  exit;
}
$job = $result->fetch_assoc();

// تسجيل زيارة اليوم
$today = date('Y-m-d');
$check_stmt = $conn->prepare("SELECT 1 FROM visitors WHERE post_id = ? AND datee = ?");
$check_stmt->bind_param("is", $job_id, $today);
$check_stmt->execute();
if ($check_stmt->get_result()->num_rows === 0) {
  $insert_stmt = $conn->prepare("INSERT INTO visitors (post_id, datee) VALUES (?, ?)");
  $insert_stmt->bind_param("is", $job_id, $today);
  $insert_stmt->execute();
}

// عداد الزوار
$count_stmt = $conn->prepare("SELECT COUNT(*) AS visits FROM visitors WHERE post_id = ?");
$count_stmt->bind_param("i", $job_id);
$count_stmt->execute();
$visits = $count_stmt->get_result()->fetch_assoc()['visits'];

// توليد صورة OG وحفظها
$og_image_path = "../og-images/job_$job_id.png";
if (!file_exists($og_image_path)) {
  $width = 1200;
  $height = 630;
  $image = imagecreatetruecolor($width, $height);
  $white = imagecolorallocate($image, 255, 255, 255);
  $black = imagecolorallocate($image, 30, 30, 30);
  $blue = imagecolorallocate($image, 52, 152, 219);
  $gray = imagecolorallocate($image, 100, 100, 100);
  imagefill($image, 0, 0, $white);

  $font_path = __DIR__ . "/fonts/arabic.ttf"; // تأكد من وجود الخط
  if (file_exists($font_path)) {
    imagettftext($image, 40, 0, 60, 120, $blue, $font_path, "📌 الوظيفة:");
    imagettftext($image, 50, 0, 60, 180, $black, $font_path, $job['job_title']);
    imagettftext($image, 36, 0, 60, 270, $gray, $font_path, "📍 المكان: " . $job['city'] . " - " . $job['country']);
    imagettftext($image, 36, 0, 60, 340, $gray, $font_path, "🗓️ التاريخ: " . $job['add_date']);
    imagettftext($image, 20, 0, 60, 600, $gray, $font_path, "/");
    imagepng($image, $og_image_path);
  }
  imagedestroy($image);
}

$og_image = "../" . $og_image_path;
$page_title = htmlspecialchars($job['job_title']);
$page_description = mb_substr(strip_tags($job['desciption']), 0, 150);
$link = "../readmore.php?job=" . $job_id;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?> | JobsAgent</title>
  <?php include 'includes/header.php'; ?>
  <meta name="description" content="<?= $page_description ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:title" content="<?= $page_title ?>">
  <meta property="og:description" content="<?= $page_description ?>">
  <meta property="og:image" content="<?= $og_image ?>">
  <meta property="og:url" content="<?= $link ?>">
  <meta property="og:type" content="article">
  <meta property="og:site_name" content="JobsAgent">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= $page_title ?>">
  <meta name="twitter:description" content="<?= $page_description ?>">
  <meta name="twitter:image" content="<?= $og_image ?>">
  <link rel="icon" href="/favicon.ico">
</head>
<body>
<div class="container py-4">
  <div class="bg-white p-4 rounded shadow-sm">
    <h2><?= htmlspecialchars($job['job_title']) ?></h2>
    <p><i class="fa fa-building text-muted"></i> <?= htmlspecialchars($job['company']) ?></p>
    <p><i class="fa fa-map-marker-alt text-muted"></i> <?= $job['city'] ?> - <?= $job['country'] ?></p>
    <p><i class="fa fa-tags text-muted"></i> <?= $job['category'] ?> | <?= $job['type'] ?></p>
    <p><i class="fa fa-calendar text-muted"></i> <?= $job['add_date'] ?></p>
    <?php if ($job['salary']): ?>
      <p><i class="fa fa-money-bill text-muted"></i> الراتب: <?= $job['salary'] ?></p>
    <?php endif; ?>
    <hr>
    <div><?= nl2br($job['desciption']) ?></div>
    <hr>
    <?php if ($job['email']): ?>
      <a href="mailto:<?= $job['email'] ?>" class="btn btn-primary"><i class="fa fa-envelope"></i> تواصل عبر البريد</a>
    <?php endif; ?>
    <?php if ($job['link']): ?>
      <a href="<?= $job['link'] ?>" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-link"></i> رابط خارجي</a>
    <?php endif; ?>
    <?php
    $fav_stmt = $conn->prepare("SELECT 1 FROM favorites WHERE user_id = ? AND job_id = ?");
    $fav_stmt->bind_param("ii", $_SESSION['user_id'], $job_id);
    $fav_stmt->execute();
    $is_favorited = $fav_stmt->get_result()->num_rows > 0;
    ?>
    <button id="fav-btn" class="btn btn-sm <?= $is_favorited ? 'btn-secondary' : 'btn-outline-warning' ?>" <?= $is_favorited ? 'disabled' : '' ?>>
      <i class="fa fa-star"></i> <?= $is_favorited ? 'تمت الإضافة إلى المفضلة' : 'أضف إلى المفضلة' ?>
    </button>
    <div class="mt-3">
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($link) ?>" target="_blank" class="btn btn-sm btn-primary">
        <i class="fab fa-facebook"></i> مشاركة على فيسبوك
      </a>
      <a href="https://twitter.com/intent/tweet?text=<?= urlencode($job['job_title'] . ' ' . $link) ?>" target="_blank" class="btn btn-sm btn-info">
        <i class="fab fa-twitter"></i> مشاركة على تويتر
      </a>
      <a href="https://wa.me/?text=<?= urlencode($job['job_title'] . ' ' . $link) ?>" target="_blank" class="btn btn-sm btn-success">
        <i class="fab fa-whatsapp"></i> مشاركة على واتساب
      </a>
    </div>
    <hr>
    <p class="text-muted"><i class="fa fa-eye"></i> عدد الزوار: <?= $visits ?></p>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
<script>
document.getElementById('fav-btn')?.addEventListener('click', function () {
  fetch('add_favorite.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'job_id=<?= $job_id ?>'
  })
  .then(res => res.text())
  .then(response => {
    if (response === 'added') {
      const btn = document.getElementById('fav-btn');
      btn.classList.remove('btn-outline-warning');
      btn.classList.add('btn-secondary');
      btn.innerHTML = '<i class="fa fa-star"></i> تمت الإضافة إلى المفضلة';
      btn.disabled = true;
    }
  });
});
</script>
</body>
</html>

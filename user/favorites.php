<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}
include '../db.php';
$page_title = "وظائفي المفضلة";
include '../includes/header.php';

$uid = $_SESSION['user_id'];

// إنشاء جدول المفضلة إذا لم يكن موجودًا
$conn->query("CREATE TABLE IF NOT EXISTS favorites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  job_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if (isset($_GET['add'])) {
  $job_id = intval($_GET['add']);
  $stmt = $conn->prepare("INSERT IGNORE INTO favorites (user_id, job_id) VALUES (?, ?)");
  $stmt->bind_param("ii", $uid, $job_id);
  $stmt->execute();
  header("Location: favorites.php");
  exit;
}

if (isset($_GET['remove'])) {
  $job_id = intval($_GET['remove']);
  $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND job_id = ?");
  $stmt->bind_param("ii", $uid, $job_id);
  $stmt->execute();
  header("Location: favorites.php");
  exit;
}

$favs = $conn->prepare("SELECT j.id, j.job_title, j.company, j.add_date 
                        FROM favorites f 
                        JOIN jobs j ON f.job_id = j.id 
                        WHERE f.user_id = ? ORDER BY f.created_at DESC");
$favs->bind_param("i", $uid);
$favs->execute();
$result = $favs->get_result();
?>
<h3><i class="fa fa-heart text-danger"></i> الوظائف المفضلة</h3>

<?php if ($result->num_rows > 0): ?>
  <div class="row">
    <?php while($job = $result->fetch_assoc()): ?>
      <div class="col-md-6">
        <div class="bg-white p-3 mb-3 rounded shadow-sm">
          <h5><a href="../readmore.php?job=<?= $job['id'] ?>"><?= htmlspecialchars($job['job_title']) ?></a></h5>
          <p class="text-muted mb-1"><i class="fa fa-building"></i> <?= htmlspecialchars($job['company']) ?></p>
          <p class="text-muted"><i class="fa fa-calendar"></i> <?= $job['add_date'] ?></p>
          <a href="favorites.php?remove=<?= $job['id'] ?>" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> إزالة</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <div class="alert alert-info">لم تقم بحفظ أي وظيفة بعد.</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>

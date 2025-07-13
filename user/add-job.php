<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

$uid = $_SESSION['user_id'];
$cats = $conn->query("SELECT * FROM jobs_cat ORDER BY job ASC");
$types = $conn->query("SELECT * FROM jobs_type ORDER BY name ASC");
$countries = $conn->query("SELECT * FROM countries ORDER BY name ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $desc = $_POST['desc'];
  $company = $_POST['company'];
  $email = $_POST['email'];
  $link = $_POST['link'];
  $salary = $_POST['salary'];
  $cat = $_POST['cat'];
  $type = $_POST['type'];
  $city = $_POST['city'];
  $country = $_POST['country'];

  $stmt = $conn->prepare("INSERT INTO jobs (job_title, desciption, company, email, link, salary, job_cat_id, job_type_id, city_id, country_id, visable, add_date, date, user_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, CURDATE(), CURDATE(), ?)");
  $stmt->bind_param("sssssiiiiii", $title, $desc, $company, $email, $link, $salary, $cat, $type, $city, $country, $uid);
  $stmt->execute();
  header("Location: dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إضافة وظيفة</title>
<?php include '../includes/header.php';
?>
</head>
<body>
<div class="container mt-4">
  <h3>إضافة وظيفة جديدة</h3>
  <form method="POST" class="row g-3">
    <div class="col-md-6"><input name="title" class="form-control" placeholder="عنوان الوظيفة" required></div>
    <div class="col-md-6"><input name="company" class="form-control" placeholder="اسم الشركة" required></div>
    <div class="col-md-12"><textarea name="desc" class="form-control" rows="5" placeholder="وصف الوظيفة" required></textarea></div>
    <div class="col-md-4"><input name="email" class="form-control" placeholder="بريد التواصل (اختياري)"></div>
    <div class="col-md-4"><input name="link" class="form-control" placeholder="رابط خارجي (اختياري)"></div>
    <div class="col-md-4"><input name="salary" class="form-control" placeholder="الراتب (اختياري)" type="number"></div>

    <div class="col-md-3">
      <select name="cat" class="form-select" required>
        <option value="">تصنيف الوظيفة</option>
        <?php while($c = $cats->fetch_assoc()): ?>
          <option value="<?= $c['id'] ?>"><?= $c['job'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="col-md-3">
      <select name="type" class="form-select" required>
        <option value="">نوع الوظيفة</option>
        <?php while($t = $types->fetch_assoc()): ?>
          <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="col-md-3">
      <select name="country" id="country" class="form-select" required>
        <option value="">الدولة</option>
        <?php while($cn = $countries->fetch_assoc()): ?>
          <option value="<?= $cn['id'] ?>"><?= $cn['name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="col-md-3">
      <select name="city" id="city" class="form-select" required>
        <option value="">المدينة</option>
      </select>
    </div>

    <div class="col-12"><button class="btn btn-success w-100">نشر الوظيفة</button></div>
  </form>
</div>

<script>
document.getElementById('country').addEventListener('change', function () {
  const countryId = this.value;
  const citySelect = document.getElementById('city');
  citySelect.innerHTML = '<option>جاري التحميل...</option>';

  fetch('get_cities.php?country_id=' + countryId)
    .then(response => response.json())
    .then(data => {
      citySelect.innerHTML = '<option value="">المدينة</option>';
      data.forEach(city => {
        const option = document.createElement('option');
        option.value = city.id;
        option.textContent = city.name;
        citySelect.appendChild(option);
      });
    })
    .catch(error => {
      citySelect.innerHTML = '<option>حدث خطأ</option>';
      console.error('خطأ في تحميل المدن:', error);
    });
});
</script>

<?php include '../includes/footer.php'; ?>

</body>
</html>

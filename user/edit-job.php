<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}
include '../db.php';
$page_title = "تعديل وظيفة";
include '../includes/header.php';

$uid = $_SESSION['user_id'];
$job_id = intval($_GET['id']);
$job = $conn->query("SELECT * FROM jobs WHERE id = $job_id AND user_id = $uid")->fetch_assoc();
if (!$job) {
  echo "<div class='alert alert-danger'>لا يمكنك تعديل هذه الوظيفة.</div>";
  include '../includes/footer.php';
  exit;
}

$cats = $conn->query("SELECT * FROM jobs_cat ORDER BY job ASC");
$types = $conn->query("SELECT * FROM jobs_type ORDER BY name ASC");
$cities = $conn->query("SELECT * FROM cities ORDER BY name ASC LIMIT 100");
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

  $stmt = $conn->prepare("UPDATE jobs SET job_title=?, desciption=?, company=?, email=?, link=?, salary=?, job_cat_id=?, job_type_id=?, city_id=?, country_id=? WHERE id=? AND user_id=?");
  $stmt->bind_param("ssssssiiiiii", $title, $desc, $company, $email, $link, $salary, $cat, $type, $city, $country, $job_id, $uid);
  $stmt->execute();
  header("Location: dashboard.php");
  exit;
}
?>
<h3>تعديل وظيفة</h3>
<form method="POST" class="row g-3">
  <div class="col-md-6"><input name="title" class="form-control" value="<?= $job['job_title'] ?>" required></div>
  <div class="col-md-6"><input name="company" class="form-control" value="<?= $job['company'] ?>" required></div>
  <div class="col-md-12"><textarea name="desc" class="form-control" rows="5" required><?= $job['desciption'] ?></textarea></div>
  <div class="col-md-4"><input name="email" class="form-control" value="<?= $job['email'] ?>"></div>
  <div class="col-md-4"><input name="link" class="form-control" value="<?= $job['link'] ?>"></div>
  <div class="col-md-4"><input name="salary" class="form-control" value="<?= $job['salary'] ?>"></div>
  <div class="col-md-3">
    <select name="cat" class="form-select" required>
      <?php while($c = $cats->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= $job['job_cat_id'] == $c['id'] ? 'selected' : '' ?>><?= $c['job'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-md-3">
    <select name="type" class="form-select" required>
      <?php while($t = $types->fetch_assoc()): ?>
        <option value="<?= $t['id'] ?>" <?= $job['job_type_id'] == $t['id'] ? 'selected' : '' ?>><?= $t['name'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-md-3">
    <select name="city" class="form-select" required>
      <?php while($ct = $cities->fetch_assoc()): ?>
        <option value="<?= $ct['id'] ?>" <?= $job['city_id'] == $ct['id'] ? 'selected' : '' ?>><?= $ct['name'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-md-3">
    <select name="country" class="form-select" required>
      <?php while($cn = $countries->fetch_assoc()): ?>
        <option value="<?= $cn['id'] ?>" <?= $job['country_id'] == $cn['id'] ? 'selected' : '' ?>><?= $cn['name'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-12"><button class="btn btn-success w-100">حفظ التعديلات</button></div>
</form>
<?php include '../includes/footer.php'; ?>

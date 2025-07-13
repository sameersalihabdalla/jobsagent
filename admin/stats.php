<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "إحصائيات الموقع";
include '../includes/header.php';

$total_jobs = $conn->query("SELECT COUNT(*) AS total FROM jobs")->fetch_assoc()['total'];
$total_users = $conn->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc()['total'];
$total_cats = $conn->query("SELECT COUNT(*) AS total FROM jobs_cat")->fetch_assoc()['total'];
$total_types = $conn->query("SELECT COUNT(*) AS total FROM jobs_type")->fetch_assoc()['total'];
$total_favs = $conn->query("SELECT COUNT(*) AS total FROM favorites")->fetch_assoc()['total'];
?>
<h3><i class="fa fa-chart-bar text-primary"></i> إحصائيات الموقع</h3>
<div class="row g-3">
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm text-center">
      <h5>عدد الوظائف</h5>
      <p class="display-6 text-primary"><?= $total_jobs ?></p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm text-center">
      <h5>عدد المستخدمين</h5>
      <p class="display-6 text-success"><?= $total_users ?></p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm text-center">
      <h5>الوظائف المحفوظة</h5>
      <p class="display-6 text-danger"><?= $total_favs ?></p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bg-white p-3 rounded shadow-sm text-center">
      <h5>عدد التصنيفات</h5>
      <p class="display-6"><?= $total_cats ?></p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bg-white p-3 rounded shadow-sm text-center">
      <h5>عدد أنواع الوظائف</h5>
      <p class="display-6"><?= $total_types ?></p>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>

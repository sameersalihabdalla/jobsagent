<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "إعدادات الموقع";
include '../includes/header.php';

$settings = $conn->query("SELECT * FROM settings WHERE id = 1")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['site_name'];
  $desc = $_POST['site_description'];
  $og = $_POST['og_description'];
  $logo = $_POST['logo_url'];

  $stmt = $conn->prepare("UPDATE settings SET site_name = ?, site_description = ?, og_description = ?, logo_url = ? WHERE id = 1");
  $stmt->bind_param("ssss", $name, $desc, $og, $logo);
  $stmt->execute();
  header("Location: site-settings.php");
  exit;
}
?>
<h3>إعدادات الموقع</h3>
<form method="POST" class="row g-3">
  <div class="col-md-6"><input name="site_name" class="form-control" value="<?= $settings['site_name'] ?>" placeholder="اسم الموقع" required></div>
  <div class="col-md-6"><input name="logo_url" class="form-control" value="<?= $settings['logo_url'] ?>" placeholder="رابط الشعار"></div>
  <div class="col-md-12"><textarea name="site_description" class="form-control" rows="3" placeholder="وصف الموقع"><?= $settings['site_description'] ?></textarea></div>
  <div class="col-md-12"><textarea name="og_description" class="form-control" rows="2" placeholder="وصف OG"><?= $settings['og_description'] ?></textarea></div>
  <div class="col-12"><button class="btn btn-success w-100">حفظ التغييرات</button></div>
</form>
<?php include '../includes/footer.php'; ?>

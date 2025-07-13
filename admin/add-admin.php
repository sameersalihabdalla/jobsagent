<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "إضافة مشرف جديد";
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['auser'];
  $email = $_POST['aemail'];
  $pass = $_POST['apass'];
  $dob = $_POST['adob'];
  $phone = $_POST['aphone'];

  $stmt = $conn->prepare("INSERT INTO admin (auser, aemail, apass, adob, aphone) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $name, $email, $pass, $dob, $phone);
  $stmt->execute();
  header("Location: index.php");
  exit;
}
?>
<h3>إضافة مشرف جديد</h3>
<form method="POST" class="row g-3">
  <div class="col-md-6"><input name="auser" class="form-control" placeholder="اسم المشرف" required></div>
  <div class="col-md-6"><input name="aemail" class="form-control" placeholder="البريد الإلكتروني" required></div>
  <div class="col-md-6"><input name="apass" class="form-control" placeholder="كلمة المرور" required></div>
  <div class="col-md-3"><input name="adob" class="form-control" type="date" placeholder="تاريخ الميلاد"></div>
  <div class="col-md-3"><input name="aphone" class="form-control" placeholder="رقم الهاتف"></div>
  <div class="col-12"><button class="btn btn-success w-100">إضافة المشرف</button></div>
</form>
<?php include '../includes/footer.php'; ?>

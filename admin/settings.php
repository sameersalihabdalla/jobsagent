<?php
session_start();
include '../db.php';

// حماية الصفحة
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

$admin_id = $_SESSION['admin_id'];
$success = false;
$error = false;

// جلب بيانات المشرف
$stmt = $conn->prepare("SELECT auser, aemail FROM admin WHERE aid = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// تحديث البيانات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $pass = trim($_POST['pass']);

  if ($email) {
    if ($pass) {
      $stmt = $conn->prepare("UPDATE admin SET aemail = ?, apass = ? WHERE aid = ?");
      $stmt->bind_param("ssi", $email, $pass, $admin_id);
    } else {
      $stmt = $conn->prepare("UPDATE admin SET aemail = ? WHERE aid = ?");
      $stmt->bind_param("si", $email, $admin_id);
    }
    if ($stmt->execute()) {
      $success = true;
    } else {
      $error = true;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إعدادات المشرف - لوحة التحكم</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php  include '../includes/header.php';
?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">لوحة التحكم</a>
    <div class="ms-auto">
      <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="fa fa-sign-out-alt"></i> خروج</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h3><i class="fa fa-user-cog text-primary"></i> إعدادات المشرف</h3>

  <?php if ($success): ?>
    <div class="alert alert-success">تم تحديث البيانات بنجاح.</div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger">حدث خطأ أثناء التحديث.</div>
  <?php endif; ?>

  <form method="POST" class="row g-3 bg-white p-4 rounded shadow-sm">
    <div class="col-md-6">
      <label class="form-label">اسم المستخدم</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($admin['auser']) ?>" disabled>
    </div>
    <div class="col-md-6">
      <label class="form-label">البريد الإلكتروني</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['aemail']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">كلمة المرور الجديدة (اختياري)</label>
      <input type="password" name="pass" class="form-control" placeholder="اتركه فارغًا إن لم ترغب بالتغيير">
    </div>
    <div class="col-12">
      <button class="btn btn-primary"><i class="fa fa-save"></i> حفظ التغييرات</button>
    </div>
  </form>
</div>


</body>
<?php  include '../includes/footer.php';
?>

</html>

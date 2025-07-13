<?php
include '../db.php';
$page_title = "تعيين كلمة مرور جديدة";
$code = $_GET['code'] ?? '';
$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $code = $_POST['code'];
  $newpass = $_POST['newpass'];
  $hashed = password_hash($newpass, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("UPDATE user SET upass = ?, reset_code = NULL, reset_expires = NULL WHERE reset_code = ? AND reset_expires > NOW()");
  $stmt->bind_param("ss", $hashed, $code);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $success = true;
  } else {
    $error = "الرابط غير صالح أو منتهي الصلاحية.";
  }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?></title>
  <?php include '../includes/header.php';?>

</head>
<body>
<div class="container py-5">
  <h3 class="mb-4"><?= $page_title ?></h3>

  <?php if ($success): ?>
    <div class="alert alert-success">تم تغيير كلمة المرور بنجاح. <a href="login.php">تسجيل الدخول</a></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <?php if (!$success): ?>
    <form method="POST" class="row g-3">
      <input type="hidden" name="code" value="<?= htmlspecialchars($code) ?>">
      <div class="col-md-6">
        <input name="newpass" type="password" class="form-control" placeholder="كلمة المرور الجديدة" required>
      </div>
      <div class="col-md-6">
        <button class="btn btn-success w-100">تعيين كلمة المرور</button>
      </div>
    </form>
  <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>

</body>
</html>

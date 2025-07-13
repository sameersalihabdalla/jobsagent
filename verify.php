<?php
include 'db.php';
$verified = false;
$error = false;

if (isset($_GET['code'])) {
  $code = $_GET['code'];
  $stmt = $conn->prepare("UPDATE user SET is_verified = 1, verify_code = NULL WHERE verify_code = ?");
  $stmt->bind_param("s", $code);
  $stmt->execute();
  $verified = $stmt->affected_rows > 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $code = $_POST['code'];
  $stmt = $conn->prepare("UPDATE user SET is_verified = 1, verify_code = NULL WHERE verify_code = ?");
  $stmt->bind_param("s", $code);
  $stmt->execute();
  $verified = $stmt->affected_rows > 0;
  if (!$verified) $error = true;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تفعيل الحساب</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h3 class="mb-4">تفعيل البريد الإلكتروني</h3>

  <?php if (isset($_GET['sent'])): ?>
    <div class="alert alert-info">تم إرسال رابط التفعيل إلى بريدك الإلكتروني.</div>
  <?php endif; ?>

  <?php if ($verified): ?>
    <div class="alert alert-success">تم تفعيل حسابك بنجاح! يمكنك الآن تسجيل الدخول.</div>
    <a href="login.php" class="btn btn-primary">تسجيل الدخول</a>
  <?php else: ?>
    <?php if ($error): ?>
      <div class="alert alert-danger">رمز التفعيل غير صحيح.</div>
    <?php endif; ?>
    <form method="POST" class="row g-3">
      <div class="col-md-6">
        <input name="code" class="form-control" placeholder="أدخل رمز التفعيل" required>
      </div>
      <div class="col-md-6">
        <button class="btn btn-success w-100">تفعيل</button>
      </div>
    </form>
  <?php endif; ?>
</div>
</body>
</html>

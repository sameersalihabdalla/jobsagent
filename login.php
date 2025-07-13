<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['uemail'];
  $pass = $_POST['upass'];

  $stmt = $conn->prepare("SELECT uid FROM user WHERE uemail = ? AND upass = ?");
  $stmt->bind_param("ss", $email, $pass);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $_SESSION['user_id'] = $row['uid'];
    $redirect = $_GET['redirect'] ?? 'index.php';
    header("Location: $redirect");
    exit;
  } else {
    $error = true;
  }
}

$page_title = "تسجيل الدخول";
include 'includes/header.php';
?>
<h3>تسجيل الدخول</h3>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger">بيانات الدخول غير صحيحة.</div>
<?php endif; ?>
<form method="POST" class="row g-3">
  <div class="col-md-6"><input name="uemail" class="form-control" placeholder="البريد الإلكتروني" required></div>
  <div class="col-md-6"><input name="upass" class="form-control" placeholder="كلمة المرور" required></div>
  <div class="col-12"><button class="btn btn-primary w-100">دخول</button></div>
  <div class="col-12"><a href="user/forgot.php" class="btn btn-danger w-100">نسيت كلمة المرور</a></div>

</form>
<?php include 'includes/footer.php'; ?>

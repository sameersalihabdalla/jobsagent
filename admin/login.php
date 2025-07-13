<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $pass = $_POST['pass'];

  $stmt = $conn->prepare("SELECT aid FROM admin WHERE aemail = ? AND apass = ?");
  $stmt->bind_param("ss", $email, $pass);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $_SESSION['admin_id'] = $row['aid'];
    header("Location: index.php");
    exit;
  } else {
    $error = true;
  }
}

$page_title = "دخول المشرف";
include '../includes/header.php';
?>
<h3>دخول المشرف</h3>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger">بيانات الدخول غير صحيحة.</div>
<?php endif; ?>
<form method="POST" class="row g-3">
  <div class="col-md-6"><input name="email" class="form-control" placeholder="البريد الإلكتروني" required></div>
  <div class="col-md-6"><input name="pass" class="form-control" placeholder="كلمة المرور" required></div>
  <div class="col-12"><button class="btn btn-dark w-100">دخول</button></div>
</form>
<?php include '../includes/footer.php'; ?>

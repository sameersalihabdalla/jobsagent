<?php
include 'db.php';

$page_title = "تسجيل مستخدم جديد";
$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['uname']);
  $email = trim($_POST['uemail']);
  $pass = $_POST['upass'];
  $phone = trim($_POST['uphone']);
  $type = $_POST['utype'];

  // التحقق من وجود البريد مسبقًا
  $check = $conn->prepare("SELECT uid FROM user WHERE uemail = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    $error = "البريد الإلكتروني مستخدم بالفعل.";
  } else {
    $verify_code = bin2hex(random_bytes(16));
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user (uname, uemail, upass, uphone, utype, verify_code) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $hashed_pass, $phone, $type, $verify_code);
    $stmt->execute();

    // إعداد البريد الإلكتروني
    $subject = "تفعيل حسابك في JobsAgent";
    $link = "https://jobsagent.org/verify.php?code=$verify_code";
    $message = "مرحباً $name،\n\nيرجى تفعيل حسابك عبر الرابط التالي:\n$link\n\nأو أدخل الرمز التالي في صفحة التفعيل:\n$verify_code";
    $headers = "From: no-reply@jobsagent.org\r\nContent-Type: text/plain; charset=UTF-8";

    mail($email, $subject, $message, $headers);

    header("Location: verify.php?sent=1");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?></title>
<?php include 'includes/header.php';?>
</head>
<body>
<div class="container py-5">
  <h3 class="mb-4"><?= $page_title ?></h3>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <input name="uname" class="form-control" placeholder="الاسم الكامل" required>
    </div>
    <div class="col-md-6">
      <input name="uemail" type="email" class="form-control" placeholder="البريد الإلكتروني" required>
    </div>
    <div class="col-md-6">
      <input name="upass" type="password" class="form-control" placeholder="كلمة المرور" required>
    </div>
    <div class="col-md-3">
      <input name="uphone" class="form-control" placeholder="رقم الهاتف">
    </div>
    <div class="col-md-3">
      <select name="utype" class="form-select form-control" required>
        <option value="باحث عن عمل">باحث عن عمل</option>
        <option value="صاحب عمل">صاحب عمل</option>
      </select>
    </div>
    <div class="col-12">
      <button class="btn btn-success w-100">تسجيل</button>
    </div>
  </form>
</div>
<?php include 'includes/footer.php'; ?>

</body>
</html>

<?php
include '../db.php';
$page_title = "استعادة كلمة المرور";
$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);

  $stmt = $conn->prepare("SELECT uid, uname FROM user WHERE uemail = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    $code = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', time() + 3600); // ساعة واحدة

    $update = $conn->prepare("UPDATE user SET reset_code = ?, reset_expires = ? WHERE uid = ?");
    $update->bind_param("ssi", $code, $expires, $user['uid']);
    $update->execute();

    $link = "https://jobsagent.org/reset.php?code=$code";
    $subject = "إعادة تعيين كلمة المرور";
    $message = "مرحباً {$user['uname']},\n\nلإعادة تعيين كلمة المرور، اضغط على الرابط التالي:\n$link\n\nالرابط صالح لمدة ساعة واحدة.";
    $headers = "From: no-reply@jobsagent.org\r\nContent-Type: text/plain; charset=UTF-8";

    mail($email, $subject, $message, $headers);
    $success = true;
  } else {
    $error = "البريد الإلكتروني غير مسجل.";
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
    <div class="alert alert-success">تم إرسال رابط إعادة التعيين إلى بريدك الإلكتروني.</div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <input name="email" type="email" class="form-control" placeholder="البريد الإلكتروني" required>
    </div>
    <div class="col-md-6">
      <button class="btn btn-primary w-100">إرسال رابط الاستعادة</button>
    </div>
  </form>
</div>
<?php include '../includes/footer.php'; ?>

</body>
</html>

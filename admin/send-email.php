<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "إرسال بريد للمستخدمين";
include '../includes/header.php';

$users = $conn->query("SELECT uemail FROM user");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  $settings = $conn->query("SELECT * FROM email_settings WHERE id = 1")->fetch_assoc();
  if (!$settings) {
    echo "<div class='alert alert-danger'>يرجى ضبط إعدادات البريد أولاً.</div>";
  } else {
    require '../vendor/autoload.php'; // تأكد من وجود PHPMailer

    while ($u = $users->fetch_assoc()) {
      $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
      $mail->Host = $settings['smtp_host'];
      $mail->Port = $settings['smtp_port'];
      $mail->SMTPAuth = true;
      $mail->Username = $settings['smtp_user'];
      $mail->Password = $settings['smtp_pass'];
      $mail->setFrom($settings['from_email'], $settings['from_name']);
      $mail->addAddress($u['uemail']);
      $mail->Subject = $subject;
      $mail->Body = $message;
      $mail->send();
    }

    echo "<div class='alert alert-success'>تم إرسال الرسائل بنجاح.</div>";
  }
}
?>
<h3><i class="fa fa-paper-plane text-success"></i> إرسال بريد جماعي</h3>
<form method="POST" class="row g-3">
  <div class="col-12"><input name="subject" class="form-control" placeholder="الموضوع" required></div>
  <div class="col-12"><textarea name="message" class="form-control" rows="6" placeholder="محتوى الرسالة" required></textarea></div>
  <div class="col-12"><button class="btn btn-primary w-100">إرسال الآن</button></div>
</form>
<?php include '../includes/footer.php'; ?>

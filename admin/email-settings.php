<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "إعدادات البريد الإلكتروني";
include '../includes/header.php';

// إنشاء جدول الإعدادات البريدية إذا لم يكن موجودًا
$conn->query("CREATE TABLE IF NOT EXISTS email_settings (
  id INT PRIMARY KEY,
  smtp_host VARCHAR(255),
  smtp_port INT,
  smtp_user VARCHAR(255),
  smtp_pass VARCHAR(255),
  from_email VARCHAR(255),
  from_name VARCHAR(255)
)");

$settings = $conn->query("SELECT * FROM email_settings WHERE id = 1")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $host = $_POST['smtp_host'];
  $port = $_POST['smtp_port'];
  $user = $_POST['smtp_user'];
  $pass = $_POST['smtp_pass'];
  $from_email = $_POST['from_email'];
  $from_name = $_POST['from_name'];

  if ($settings) {
    $stmt = $conn->prepare("UPDATE email_settings SET smtp_host=?, smtp_port=?, smtp_user=?, smtp_pass=?, from_email=?, from_name=? WHERE id=1");
    $stmt->bind_param("sissss", $host, $port, $user, $pass, $from_email, $from_name);
  } else {
    $stmt = $conn->prepare("INSERT INTO email_settings (id, smtp_host, smtp_port, smtp_user, smtp_pass, from_email, from_name) VALUES (1, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $host, $port, $user, $pass, $from_email, $from_name);
  }

  $stmt->execute();
  header("Location: email-settings.php");
  exit;
}
?>
<h3><i class="fa fa-envelope text-primary"></i> إعدادات البريد الإلكتروني</h3>
<form method="POST" class="row g-3">
  <div class="col-md-6"><input name="smtp_host" class="form-control" placeholder="SMTP Host" value="<?= $settings['smtp_host'] ?? '' ?>" required></div>
  <div class="col-md-3"><input name="smtp_port" class="form-control" placeholder="SMTP Port" value="<?= $settings['smtp_port'] ?? '' ?>" required></div>
  <div class="col-md-3"><input name="smtp_user" class="form-control" placeholder="SMTP Username" value="<?= $settings['smtp_user'] ?? '' ?>" required></div>
  <div class="col-md-6"><input name="smtp_pass" class="form-control" placeholder="SMTP Password" value="<?= $settings['smtp_pass'] ?? '' ?>" required></div>
  <div class="col-md-3"><input name="from_email" class="form-control" placeholder="From Email" value="<?= $settings['from_email'] ?? '' ?>" required></div>
  <div class="col-md-3"><input name="from_name" class="form-control" placeholder="From Name" value="<?= $settings['from_name'] ?? '' ?>" required></div>
  <div class="col-12"><button class="btn btn-success w-100">حفظ الإعدادات</button></div>
</form>
<?php include '../includes/footer.php'; ?>

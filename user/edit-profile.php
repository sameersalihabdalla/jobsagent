<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}
include '../db.php';
$page_title = "تعديل الحساب";
include '../includes/header.php';

$uid = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM user WHERE uid = $uid")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['uname'];
  $email = $_POST['uemail'];
  $pass = $_POST['upass'];
  $phone = $_POST['uphone'];
  $type = $_POST['utype'];

  $stmt = $conn->prepare("UPDATE user SET uname = ?, uemail = ?, upass = ?, uphone = ?, utype = ? WHERE uid = ?");
  $stmt->bind_param("sssssi", $name, $email, $pass, $phone, $type, $uid);
  $stmt->execute();
  header("Location: dashboard.php");
  exit;
}
?>
<h3>تعديل بيانات الحساب</h3>
<form method="POST" class="row g-3">
  <div class="col-md-6"><input name="uname" class="form-control" value="<?= $user['uname'] ?>" required></div>
  <div class="col-md-6"><input name="uemail" class="form-control" value="<?= $user['uemail'] ?>" required></div>
  <div class="col-md-6"><input name="upass" type="password" class="form-control" value="<?= $user['upass'] ?>" required></div>
  <div class="col-md-3"><input name="uphone" class="form-control" value="<?= $user['uphone'] ?>"></div>
  <div class="col-md-3">
    <select name="utype" class="form-select form-control">
      <option value="باحث عن عمل" <?= $user['utype'] == 'باحث عن عمل' ? 'selected' : '' ?>>باحث عن عمل</option>
      <option value="صاحب عمل" <?= $user['utype'] == 'صاحب عمل' ? 'selected' : '' ?>>صاحب عمل</option>
    </select>
  </div>
  <div class="col-12"><button class="btn btn-success w-100">حفظ التغييرات</button></div>
</form>
<?php include '../includes/footer.php'; ?>

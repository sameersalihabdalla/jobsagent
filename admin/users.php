<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "إدارة المستخدمين";
include '../includes/header.php';

$users = $conn->query("SELECT * FROM user ORDER BY uid DESC");
?>
<h3>إدارة المستخدمين</h3>
<table class="table table-bordered table-hover bg-white">
  <thead class="table-light">
    <tr>
      <th>الاسم</th>
      <th>البريد</th>
      <th>الهاتف</th>
      <th>النوع</th>
      <th>تحكم</th>
    </tr>
  </thead>
  <tbody>
    <?php while($u = $users->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($u['uname']) ?></td>
      <td><?= htmlspecialchars($u['uemail']) ?></td>
      <td><?= htmlspecialchars($u['uphone']) ?></td>
      <td><?= htmlspecialchars($u['utype']) ?></td>
      <td>
        <a href="delete-user.php?id=<?= $u['uid'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('حذف المستخدم؟')"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?>

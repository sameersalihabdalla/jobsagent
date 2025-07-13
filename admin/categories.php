<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "إدارة التصنيفات";
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['job'];
  $name_en = $_POST['job_en'];
  $logo = $_POST['logo'];
  $stmt = $conn->prepare("INSERT INTO jobs_cat (job, job_en, logo) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $name_en, $logo);
  $stmt->execute();
  header("Location: categories.php");
  exit;
}

$cats = $conn->query("SELECT * FROM jobs_cat ORDER BY id DESC");
?>
<h3>إدارة التصنيفات</h3>
<form method="POST" class="row g-3 mb-4">
  <div class="col-md-4"><input name="job" class="form-control" placeholder="اسم التصنيف" required></div>
  <div class="col-md-4"><input name="job_en" class="form-control" placeholder="الاسم بالإنجليزية"></div>
  <div class="col-md-4"><input name="logo" class="form-control" placeholder="رابط الشعار (اختياري)"></div>
  <div class="col-12"><button class="btn btn-primary">إضافة</button></div>
</form>

<table class="table table-bordered table-hover bg-white">
  <thead class="table-light">
    <tr>
      <th>الاسم</th>
      <th>الإنجليزية</th>
      <th>الشعار</th>
      <th>تحكم</th>
    </tr>
  </thead>
  <tbody>
    <?php while($c = $cats->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($c['job']) ?></td>
      <td><?= htmlspecialchars($c['job_en']) ?></td>
      <td><?= $c['logo'] ? "<img src='{$c['logo']}' width='40'>" : '-' ?></td>
      <td>
        <a href="delete-category.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('حذف التصنيف؟')"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?>

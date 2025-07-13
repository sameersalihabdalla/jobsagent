<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "أنواع الوظائف";
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $name_en = $_POST['name_en'];
  $stmt = $conn->prepare("INSERT INTO jobs_type (name, name_en) VALUES (?, ?)");
  $stmt->bind_param("ss", $name, $name_en);
  $stmt->execute();
  header("Location: types.php");
  exit;
}

$types = $conn->query("SELECT * FROM jobs_type ORDER BY id DESC");
?>
<h3>أنواع الوظائف</h3>
<form method="POST" class="row g-3 mb-4">
  <div class="col-md-6"><input name="name" class="form-control" placeholder="الاسم" required></div>
  <div class="col-md-6"><input name="name_en" class="form-control" placeholder="الاسم بالإنجليزية"></div>
  <div class="col-12"><button class="btn btn-primary">إضافة</button></div>
</form>

<table class="table table-bordered table-hover bg-white">
  <thead class="table-light">
    <tr>
      <th>الاسم</th>
      <th>الإنجليزية</th>
      <th>تحكم</th>
    </tr>
  </thead>
  <tbody>
    <?php while($t = $types->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($t['name']) ?></td>
      <td><?= htmlspecialchars($t['name_en']) ?></td>
      <td>
        <a href="delete-type.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('حذف النوع؟')"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}
include '../db.php';
$page_title = "لوحة المستخدم";
include '../includes/header.php';

$uid = $_SESSION['user_id'];
$user = $conn->query("SELECT uname FROM user WHERE uid = $uid")->fetch_assoc();
$jobs = $conn->query("SELECT * FROM jobs WHERE user_id = $uid ORDER BY add_date DESC");
$favs = $conn->query("SELECT COUNT(*) AS total FROM favorites WHERE user_id = $uid")->fetch_assoc();
?>
<h3>مرحبًا <?= htmlspecialchars($user['uname']) ?> 👋</h3>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm text-center">
      <h5><i class="fa fa-briefcase text-primary"></i> وظائفك</h5>
      <p><?= $jobs->num_rows ?> وظيفة منشورة</p>
      <a href="add-job.php" class="btn btn-sm btn-success">إضافة وظيفة جديدة</a>
    </div>
  </div>
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm text-center">
      <h5><i class="fa fa-heart text-danger"></i> المفضلة</h5>
      <p><?= $favs['total'] ?> وظيفة محفوظة</p>
      <a href="favorites.php" class="btn btn-sm btn-outline-danger">عرض المفضلة</a>
    </div>
  </div>
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm text-center">
      <h5><i class="fa fa-user-cog text-secondary"></i> حسابك</h5>
      <p>تعديل بياناتك الشخصية</p>
      <a href="edit-profile.php" class="btn btn-sm btn-outline-secondary">تعديل الحساب</a>
    </div>
  </div>
</div>

<h4 class="mt-4">وظائفك المنشورة</h4>
<?php if ($jobs->num_rows > 0): ?>
  <table class="table table-bordered table-hover bg-white">
    <thead class="table-light">
      <tr>
        <th>العنوان</th>
        <th>الشركة</th>
        <th>التاريخ</th>
        <th>تحكم</th>
      </tr>
    </thead>
    <tbody>
      <?php while($job = $jobs->fetch_assoc()): ?>
      <tr>
        <td><a href="../readmore.php?job=<?= $job['id'] ?>" target="_blank"><?= htmlspecialchars($job['job_title']) ?></a></td>
        <td><?= htmlspecialchars($job['company']) ?></td>
        <td><?= $job['add_date'] ?></td>
        <td>
          <a href="edit-job.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></a>
          <a href="delete-job.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')"><i class="fa fa-trash"></i></a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php else: ?>
  <div class="alert alert-info">لم تقم بنشر أي وظيفة بعد.</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>

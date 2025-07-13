<?php
session_start();
include '../db.php';
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}
$uid = $_SESSION['user_id'];

// حذف وظيفة
if (isset($_GET['delete'])) {
  $job_id = intval($_GET['delete']);
  $conn->query("DELETE FROM jobs WHERE id = $job_id AND user_id = $uid");
  header("Location: my-jobs.php");
  exit;
}

// جلب الوظائف الخاصة بالمستخدم
$stmt = $conn->prepare("SELECT * FROM jobs WHERE user_id = ? ORDER BY add_date DESC");
$stmt->bind_param("i", $uid);
$stmt->execute();
$jobs = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>وظائفي - JobsAgent</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h3><i class="fa fa-briefcase text-primary"></i> الوظائف التي أضفتها</h3>
  <?php if ($jobs->num_rows > 0): ?>
    <table class="table table-bordered table-hover bg-white">
      <thead class="table-light">
        <tr>
          <th>العنوان</th>
          <th>الشركة</th>
          <th>التاريخ</th>
          <th>الحالة</th>
          <th>التحكم</th>
        </tr>
      </thead>
      <tbody>
        <?php while($job = $jobs->fetch_assoc()): ?>
          <tr>
            <td><a href="../readmore.php?job=<?= $job['id'] ?>" target="_blank"><?= htmlspecialchars($job['job_title']) ?></a></td>
            <td><?= htmlspecialchars($job['company']) ?></td>
            <td><?= $job['add_date'] ?></td>
            <td><?= $job['visable'] ? 'مرئية' : 'مخفية' ?></td>
            <td>
              <a href="edit-job.php?job=<?= $job['id'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
              <a href="?delete=<?= $job['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">لم تقم بإضافة أي وظائف بعد.</div>
  <?php endif; ?>
</div>
</body>
</html>

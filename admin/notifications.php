<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "الإشعارات";
include '../includes/header.php';

// إنشاء جدول الإشعارات إذا لم يكن موجودًا
$conn->query("CREATE TABLE IF NOT EXISTS notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  message TEXT,
  is_read TINYINT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if (isset($_GET['mark'])) {
  $nid = intval($_GET['mark']);
  $conn->query("UPDATE notifications SET is_read = 1 WHERE id = $nid");
  header("Location: notifications.php");
  exit;
}

$notifications = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC");
?>
<h3><i class="fa fa-bell text-warning"></i> الإشعارات</h3>
<?php if ($notifications->num_rows > 0): ?>
  <ul class="list-group">
    <?php while($n = $notifications->fetch_assoc()): ?>
      <li class="list-group-item d-flex justify-content-between align-items-start <?= $n['is_read'] ? '' : 'list-group-item-light' ?>">
        <div class="ms-2 me-auto">
          <div class="fw-bold"><?= htmlspecialchars($n['title']) ?></div>
          <?= nl2br(htmlspecialchars($n['message'])) ?>
          <div class="text-muted small mt-1"><?= $n['created_at'] ?></div>
        </div>
        <?php if (!$n['is_read']): ?>
          <a href="?mark=<?= $n['id'] ?>" class="btn btn-sm btn-outline-secondary">تمت القراءة</a>
        <?php endif; ?>
      </li>
    <?php endwhile; ?>
  </ul>
<?php else: ?>
  <div class="alert alert-info">لا توجد إشعارات حالياً.</div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>

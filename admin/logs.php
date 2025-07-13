<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "سجل النشاطات";
include '../includes/header.php';

// إنشاء جدول السجل إذا لم يكن موجودًا
$conn->query("CREATE TABLE IF NOT EXISTS logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  action TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$logs = $conn->query("SELECT * FROM logs ORDER BY created_at DESC LIMIT 100");
?>
<h3><i class="fa fa-history text-secondary"></i> سجل النشاطات</h3>
<table class="table table-bordered table-hover bg-white">
  <thead class="table-light">
    <tr>
      <th>العملية</th>
      <th>الوقت</th>
    </tr>
  </thead>
  <tbody>
    <?php while($log = $logs->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($log['action']) ?></td>
      <td><?= $log['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?>

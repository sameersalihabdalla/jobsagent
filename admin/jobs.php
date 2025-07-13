<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "إدارة الوظائف";
include '../includes/header.php';

// خيارات التجزئة
$limit_options = [20, 40, 60, 80, 100];
$limit = isset($_GET['limit']) && in_array((int)$_GET['limit'], $limit_options) ? (int)$_GET['limit'] : 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// حساب عدد الوظائف
$total_result = $conn->query("SELECT COUNT(*) AS total FROM jobs");
$total_row = $total_result->fetch_assoc();
$total_jobs = $total_row['total'];
$total_pages = ceil($total_jobs / $limit);

// جلب الوظائف مع LIMIT
$stmt = $conn->prepare("SELECT j.id, j.job_title, j.company, j.add_date, u.uname 
                        FROM jobs j 
                        LEFT JOIN user u ON j.user_id = u.uid 
                        ORDER BY j.add_date DESC 
                        LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$jobs = $stmt->get_result();
?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">إدارة الوظائف</h3>
    <form method="GET" class="d-flex align-items-center">
      <label class="me-2">عدد النتائج:</label>
      <select name="limit" class="form-select form-select-sm me-2" onchange="this.form.submit()">
        <?php foreach ($limit_options as $opt): ?>
          <option value="<?= $opt ?>" <?= $limit == $opt ? 'selected' : '' ?>><?= $opt ?></option>
        <?php endforeach; ?>
      </select>
      <input type="hidden" name="page" value="1">
    </form>
  </div>

  <table class="table table-bordered table-hover bg-white">
    <thead class="table-light">
      <tr>
        <th>العنوان</th>
        <th>الشركة</th>
        <th>المستخدم</th>
        <th>التاريخ</th>
        <th>تحكم</th>
      </tr>
    </thead>
    <tbody>
      <?php while($job = $jobs->fetch_assoc()): ?>
      <tr>
        <td><a href="../readmore.php?job=<?= $job['id'] ?>" target="_blank"><?= htmlspecialchars($job['job_title']) ?></a></td>
        <td><?= htmlspecialchars($job['company']) ?></td>
        <td><?= htmlspecialchars($job['uname']) ?></td>
        <td><?= $job['add_date'] ?></td>
        <td>
          <a href="delete-job.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('حذف الوظيفة؟')">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <?php if ($total_pages > 1): ?>
  <div class="container">
    <nav class="mt-4">
      <ul class="pagination justify-content-center flex-wrap" style="max-width: 100%; overflow-x: auto;">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?<?= http_build_query(['page' => $i, 'limit' => $limit]) ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  </div>
  <?php endif; ?>
</div>

<style>
  [dir="rtl"] .pagination {
    direction: ltr;
  }
</style>

<?php include '../includes/footer.php'; ?>

<?php
include 'db.php';
$page_title = "نتائج البحث";
include 'includes/header.php';

// خيارات عدد النتائج
$limit_options = [10, 20, 40, 60, 80, 100];

// قراءة مدخلات البحث
$q = $_GET['q'] ?? '';
$country = $_GET['country'] ?? '';
$type = $_GET['type'] ?? '';
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$per_page = in_array($limit, $limit_options) ? $limit : 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

// بناء شروط البحث
$where = "WHERE j.visable = 1";
$params = [];
$typestr = "";

if ($q) {
  $where .= " AND j.job_title LIKE ?";
  $params[] = "%$q%";
  $typestr .= "s";
}
if ($country) {
  $where .= " AND j.country_id = ?";
  $params[] = $country;
  $typestr .= "i";
}
if ($type) {
  $where .= " AND j.job_type_id = ?";
  $params[] = $type;
  $typestr .= "i";
}

// حساب عدد النتائج الكلي
$count_sql = "SELECT COUNT(*) FROM jobs j $where";
$count_stmt = $conn->prepare($count_sql);
if ($params) {
  $count_stmt->bind_param($typestr, ...$params);
}
$count_stmt->execute();
$count_stmt->bind_result($total_rows);
$count_stmt->fetch();
$count_stmt->close();

$total_pages = ceil($total_rows / $per_page);

// استعلام النتائج مع LIMIT و OFFSET
$sql = "SELECT j.id, j.job_title, j.company, j.add_date, c.job AS category, co.name AS country 
        FROM jobs j 
        LEFT JOIN jobs_cat c ON j.job_cat_id = c.id 
        LEFT JOIN countries co ON j.country_id = co.id 
        $where ORDER BY j.add_date DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
if ($params) {
  $typestr .= "ii";
  $params[] = $per_page;
  $params[] = $offset;
  $stmt->bind_param($typestr, ...$params);
} else {
  $stmt->bind_param("ii", $per_page, $offset);
}
$stmt->execute();
$results = $stmt->get_result();

// جلب الدول وأنواع الوظائف
$countries = $conn->query("SELECT id, name FROM countries ORDER BY name ASC");
$types = $conn->query("SELECT id, name FROM jobs_type ORDER BY name ASC");
?>

<div class="container py-4">
  <h3 class="mb-4"><i class="fa fa-search text-primary"></i> البحث عن وظيفة</h3>
  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
      <input name="q" class="form-control" placeholder="كلمة مفتاحية" value="<?= htmlspecialchars($q) ?>">
    </div>
    <div class="col-md-3">
      <select name="country" class="form-select form-control">
        <option value="">كل الدول</option>
        <?php while($c = $countries->fetch_assoc()): ?>
          <option value="<?= $c['id'] ?>" <?= $country == $c['id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-3">
      <select name="type" class="form-select form-control">
        <option value="">نوع الوظيفة</option>
        <?php while($t = $types->fetch_assoc()): ?>
          <option value="<?= $t['id'] ?>" <?= $type == $t['id'] ? 'selected' : '' ?>><?= $t['name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-3">
      <select name="limit" class="form-select form-control">
        <?php foreach ($limit_options as $opt): ?>
          <option value="<?= $opt ?>" <?= $per_page == $opt ? 'selected' : '' ?>><?= $opt ?> نتيجة</option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-12">
      <button class="btn btn-primary w-100"><i class="fa fa-search"></i> تنفيذ البحث</button>
    </div>
  </form>

  <?php if ($results->num_rows > 0): ?>
    <div class="row">
      <?php while($job = $results->fetch_assoc()): ?>
        <div class="col-md-6">
          <div class="bg-white p-4 mb-3 rounded shadow-sm border-start border-4 border-success">
            <h5 class="mb-1">
              <a href="readmore.php?job=<?= $job['id'] ?>" class="text-decoration-none text-dark">
                <?= htmlspecialchars($job['job_title']) ?>
              </a>
            </h5>
            <p class="mb-1 text-muted"><i class="fa fa-building"></i> <?= htmlspecialchars($job['company']) ?></p>
            <small class="text-muted">
              <i class="fa fa-globe"></i> <?= $job['country'] ?> |
              <i class="fa fa-tags"></i> <?= $job['category'] ?> |
              <i class="fa fa-calendar"></i> <?= $job['add_date'] ?>
            </small>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <?php if ($total_pages > 1): ?>
      <div class="container">
        <nav class="mt-4">
          <ul class="pagination justify-content-center flex-wrap">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      </div>
    <?php endif; ?>

  <?php else: ?>
    <div class="alert alert-info">لا توجد نتائج مطابقة لبحثك.</div>
  <?php endif; ?>
</div>

<style>
  [dir="rtl"] .pagination {
    direction: ltr;
  }
</style>

<?php include 'includes/footer.php'; ?>

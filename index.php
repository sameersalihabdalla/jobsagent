<?php
include 'db.php';
$page_title = "وظائف اليوم | JobsAgent";
$page_description = "منصة احترافية لنشر الوظائف وفرص العمل في السودان والعالم العربي.";
include 'includes/header.php';

$latest = $conn->query("SELECT j.id, j.job_title, j.company, j.add_date, c.job AS category, co.name AS country 
                        FROM jobs j 
                        LEFT JOIN jobs_cat c ON j.job_cat_id = c.id 
                        LEFT JOIN countries co ON j.country_id = co.id 
                        WHERE j.visable = 1 
                        ORDER BY j.add_date DESC LIMIT 8");

$countries = $conn->query("SELECT id, name FROM countries ORDER BY name ASC");
?>

<!-- Hero Section -->
<section class="bg-gradient-primary text-white text-center py-5 mb-5" style="background-color:#4d4a45 !important; color:white;">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3 text-white">اكتشف أحدث الوظائف</h1>
    <p class="lead mb-4">منصة موثوقة لفرص العمل في السودان والدول العربية والأفريقية</p>
    <form action="search.php" method="GET" class="row justify-content-center g-2">
      <div class="col-md-4">
        <input type="text" name="q" class="form-control form-control" placeholder="مثال: مهندس، محاسب..." />
      </div>
      <div class="col-md-3">
        <select name="country" class="form-select form-control">
          <option value="">كل الدول</option>
          <?php while($c = $countries->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-2">
        <button class="btn btn-light btn-lg w-100"><i class="fa fa-search"></i> بحث</button>
      </div>
    </form>
  </div>
</section>

<!-- Latest Jobs Section -->
<section class="container mb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="fa fa-briefcase me-2"></i> أحدث الوظائف</h3>
    <a href="search.php" class="btn btn-outline-primary"><i class="fa fa-list"></i> عرض جميع الوظائف</a>
  </div>

  <div class="row g-4">
    <?php while($job = $latest->fetch_assoc()): ?>
      <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <h5 class="card-title mb-2">
              <a href="readmore.php?job=<?= $job['id'] ?>" class="text-decoration-none text-dark">
                <?= htmlspecialchars($job['job_title']) ?>
              </a>
            </h5>
            <p class="card-text text-muted mb-2">
              <i class="fa fa-building me-1 text-secondary"></i> <?= htmlspecialchars($job['company']) ?>
            </p>
            <div class="d-flex flex-wrap small text-muted">
              <div class="me-3"><i class="fa fa-globe me-1"></i> <?= $job['country'] ?></div>
              <div class="me-3"><i class="fa fa-tags me-1"></i> <?= $job['category'] ?></div>
              <div><i class="fa fa-calendar me-1"></i> <?= $job['add_date'] ?></div>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Call to Action -->
<section class="bg-light py-5 text-center">
  <div class="container">
    <h4 class="fw-bold mb-3">هل تبحث عن وظيفة مميزة؟</h4>
    <p class="mb-4">ابدأ رحلتك المهنية الآن عبر منصة JobsAgent</p>
    <a href="../user/add-job.php" class="btn btn-success btn-lg"><i class="fa fa-plus-circle"></i> أضف وظيفة جديدة</a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

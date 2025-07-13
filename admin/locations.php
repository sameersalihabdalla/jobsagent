<?php
session_start();
include '../db.php';
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

$countries = $conn->query("SELECT id, name, iso2 FROM countries ORDER BY name ASC LIMIT 100");
$cities = $conn->query("SELECT name, country_id FROM cities ORDER BY name ASC LIMIT 100");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إدارة المدن والدول</title>
  <?php include '../includes/header.php';
?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">لوحة التحكم</a>
    <div class="ms-auto">
      <a href="logout.php" class="btn btn-outline-light btn-sm">خروج</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h3>الدول (أول 100)</h3>
  <table class="table table-bordered">
    <thead><tr><th>الاسم</th><th>الرمز</th></tr></thead>
    <tbody>
      <?php while($c = $countries->fetch_assoc()): ?>
        <tr><td><?= $c['name'] ?></td><td><?= $c['iso2'] ?></td></tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <h3 class="mt-5">المدن (أول 100)</h3>
  <table class="table table-bordered">
    <thead><tr><th>المدينة</th><th>الدولة</th></tr></thead>
    <tbody>
      <?php while($city = $cities->fetch_assoc()):
        $country = $conn->query("SELECT name FROM countries WHERE id = {$city['country_id']}")->fetch_assoc();
      ?>
        <tr><td><?= $city['name'] ?></td><td><?= $country['name'] ?? 'غير معروف' ?></td></tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>

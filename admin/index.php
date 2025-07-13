<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';
$page_title = "لوحة التحكم";
include '../includes/header.php';
?>
<h3>لوحة تحكم المشرف</h3>
<div class="row g-3">
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-briefcase text-primary"></i> الوظائف</h5>
      <p><a href="jobs.php" class="btn btn-sm btn-outline-primary">إدارة الوظائف</a></p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-users text-success"></i> المستخدمون</h5>
      <p><a href="users.php" class="btn btn-sm btn-outline-success">إدارة المستخدمين</a></p>
    </div>
  </div>
   <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="text-secondary"></i> 🕐 الوظائف</h5>
      <p><a href="types.php" class="btn btn-sm btn-outline-secondary">إدارة أنواع الوظائف</a></p>
    </div>
  </div>


   <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="">🧩</i>  مجالات العمل </h5>
      <p><a href="categories.php" class="btn btn-sm btn-outline-secondary">إدارة  مجالات العمل</a></p>
    </div>
  </div>
  

   <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-stats text-secondary"></i>احصائيات </h5>
      <p><a href="stats.php" class="btn btn-sm btn-outline-secondary">احصائيات الموقع </a></p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-cog text-secondary"></i> المناطق</h5>
      <p><a href="locations.php" class="btn btn-sm btn-outline-secondary"> إدارة المناطق </a></p>
    </div>
  </div>


  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-log text-secondary"></i> السجلات</h5>
      <p><a href="logs.php" class="btn btn-sm btn-outline-secondary"> إدارة السجلات </a></p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-log text-secondary"></i> الاشعارات</h5>
      <p><a href="notifications.php" class="btn btn-sm btn-outline-secondary"> إدارة الإشعارات </a></p>
    </div>
  </div>

  
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-log text-secondary"></i> البريد الالكتروني</h5>
      <p><a href="email-settings" class="btn btn-sm btn-outline-secondary"> إعدادات البريد الإلكتروني </a></p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-log text-secondary"></i> المشرفين</h5>
      <p><a href="add-admin.php" class="btn btn-sm btn-outline-secondary"> إدارة المشرفين </a></p>
    </div>
  </div>

  
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-log text-secondary"></i> الموقع</h5>
      <p><a href="site-settings.php" class="btn btn-sm btn-outline-secondary"> إدارة الموقع </a></p>
    </div>
  </div>


  
  <div class="col-md-4">
    <div class="bg-white p-3 rounded shadow-sm">
      <h5><i class="fa fa-log text-secondary"></i> حسابي</h5>
      <p><a href="settings.php" class="btn btn-sm btn-outline-secondary"> إدارة حسابي </a></p>
    </div>
  </div>


  
</div>
<?php include '../includes/footer.php'; ?>

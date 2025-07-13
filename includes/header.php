<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/../db.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?? 'JobsAgent' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= $page_description ?? 'منصة لنشر الوظائف وفرص العمل' ?>">
<!-- داخل <head> -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- قبل نهاية </body> -->
<script src="../js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">











<link rel="icon" type="image/png" href="/../img/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="../img/favicon.svg" />
<link rel="shortcut icon" href="/../img/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/../img/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="jobsagent" />
<link rel="manifest" href="/../img/site.webmanifest" />

<link rel="stylesheet" href="../css/bootstrap-datepicker.css">
<link rel="stylesheet" href="../css/jquery.timepicker.css">
<link rel="stylesheet" href="../css/flaticon.css">
<link rel="stylesheet" href="../css/icomoon.css">
<link rel="stylesheet" href="../css/ionicons.min.css">


                     
<link rel="manifest" href="manifest.json">


  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/"><i class="fa fa-briefcase"></i> JobsAgent</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item "><a class="nav-link text-white" href="/">الرئيسية</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/search.php"><i class="fa fa-search"></i> البحث</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/contact.php">اتصل بنا</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/terms.php">الشروط</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/user/add-job.php">اضف وظيفة</a></li>
        
      </ul>
      <div class="d-flex">
        <?php if (!empty($_SESSION['admin_id'])): ?>
          <a href="/admin/index.php" class="btn btn-light btn-sm me-2"><i class="fa fa-cogs"></i> لوحة المشرف</a>
          <a href="/admin/logout.php" class="btn btn-outline-light btn-sm">خروج</a>
        <?php elseif (!empty($_SESSION['user_id'])): ?>
          <a href="/user/dashboard.php" class="btn btn-light btn-sm me-2"><i class="fa fa-user"></i> حسابي</a>
          <a href="/logout.php" class="btn btn-outline-light btn-sm">خروج</a>
        <?php else: ?>
          <a href="/login.php" class="btn btn-outline-light btn-sm me-2"><i class="fa fa-sign-in-alt"></i> دخول</a>
          <a href="/register.php" class="btn btn-warning btn-sm"><i class="fa fa-user-plus"></i> تسجيل</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="container mt-4">

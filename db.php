<?php
$host = 'localhost';       // اسم السيرفر
$user = 'root';            // اسم المستخدم
$pass = '';                // كلمة المرور
$dbname = 'jobsagent';     // اسم قاعدة البيانات

$conn = new mysqli($host, $user, $pass, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
  die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// تعيين الترميز إلى UTF-8
$conn->set_charset("utf8mb4");
?>

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';

$cat_id = intval($_GET['id']);

// حذف الوظائف المرتبطة بهذا التصنيف (اختياري)
// $conn->query("DELETE FROM jobs WHERE job_cat_id = $cat_id");

$stmt = $conn->prepare("DELETE FROM jobs_cat WHERE id = ?");
$stmt->bind_param("i", $cat_id);
$stmt->execute();

header("Location: categories.php");
exit;

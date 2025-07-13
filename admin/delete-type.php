<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';

$type_id = intval($_GET['id']);

// حذف الوظائف المرتبطة بهذا النوع (اختياري)
// $conn->query("DELETE FROM jobs WHERE job_type_id = $type_id");

$stmt = $conn->prepare("DELETE FROM jobs_type WHERE id = ?");
$stmt->bind_param("i", $type_id);
$stmt->execute();

header("Location: types.php");
exit;

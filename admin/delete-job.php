<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';

$job_id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();

header("Location: jobs.php");
exit;

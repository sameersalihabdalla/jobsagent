<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}
include '../db.php';

$uid = $_SESSION['user_id'];
$job_id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $job_id, $uid);
$stmt->execute();

header("Location: dashboard.php");
exit;

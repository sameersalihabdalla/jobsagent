<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['job_id'])) {
  http_response_code(403);
  exit;
}

$user_id = $_SESSION['user_id'];
$job_id = intval($_POST['job_id']);

$stmt = $conn->prepare("INSERT IGNORE INTO favorites (user_id, job_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $job_id);
$stmt->execute();

echo "added";

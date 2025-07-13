<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
include '../db.php';

$user_id = intval($_GET['id']);

// حذف الوظائف المرتبطة بالمستخدم
$conn->query("DELETE FROM jobs WHERE user_id = $user_id");

// حذف المفضلة
$conn->query("DELETE FROM favorites WHERE user_id = $user_id");

// حذف المستخدم
$stmt = $conn->prepare("DELETE FROM user WHERE uid = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

header("Location: users.php");
exit;

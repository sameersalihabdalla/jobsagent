<?php
include '../db.php';
if (isset($_GET['country_id'])) {
  $country_id = intval($_GET['country_id']);
  $result = $conn->query("SELECT id, name FROM cities WHERE country_id = $country_id ORDER BY name ASC");
  $cities = [];
  while ($row = $result->fetch_assoc()) {
    $cities[] = $row;
  }
  echo json_encode($cities, JSON_UNESCAPED_UNICODE);
}
?>

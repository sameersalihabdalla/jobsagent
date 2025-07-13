<?php
header("Content-Type: application/xml; charset=utf-8");
include 'db.php';
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://jobsagent.org/</loc>
    <priority>1.0</priority>
  </url>
  <?php
  $jobs = $conn->query("SELECT id, add_date FROM jobs WHERE visable = 1 ORDER BY add_date DESC");
  while($job = $jobs->fetch_assoc()):
  ?>
  <url>
    <loc>https://jobsagent.org/readmore.php?job=<?= $job['id'] ?></loc>
    <lastmod><?= $job['add_date'] ?></lastmod>
    <priority>0.8</priority>
  </url>
  <?php endwhile; ?>
</urlset>

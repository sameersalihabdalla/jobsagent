<?php
session_start();
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'ar';
$_SESSION['lang'] = $lang;

$lang_file = __DIR__ . "/lang/$lang.php";
if (!file_exists($lang_file)) {
  $lang_file = __DIR__ . "/lang/ar.php";
}
$__ = include $lang_file;

<?php
session_start();
if (!isset($_SESSION['logged_in'])) exit;

$baseDir = realpath("uploads");
$path = $_POST['path'] ?? '';
$targetDir = realpath($baseDir . DIRECTORY_SEPARATOR . $path);

if (!$targetDir || strpos($targetDir, $baseDir) !== 0) die("Invalid path.");

if (!empty($_FILES['file']['name'])) {
    $filename = basename($_FILES['file']['name']);
    $destination = $targetDir . DIRECTORY_SEPARATOR . $filename;
    move_uploaded_file($_FILES['file']['tmp_name'], $destination);
}

header("Location: admin.php?path=" . urlencode($path));
exit;

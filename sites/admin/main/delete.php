<?php
session_start();
if (!isset($_SESSION['logged_in'])) exit;

$baseDir = realpath("uploads");
$relPath = $_POST['file'] ?? '';
$targetPath = realpath($baseDir . DIRECTORY_SEPARATOR . $relPath);

if ($targetPath && strpos($targetPath, $baseDir) === 0 && is_file($targetPath)) {
    unlink($targetPath);
}

$parent = dirname($relPath);
header("Location: admin.php?path=" . urlencode($parent));
exit;

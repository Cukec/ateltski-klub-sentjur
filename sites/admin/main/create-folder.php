<?php
session_start();
if (!isset($_SESSION['logged_in'])) exit;

$folder = basename($_POST['folder_name']);
$path = $_POST['path'] ?? '';
$baseDir = realpath("uploads");
$currentDir = realpath($baseDir . DIRECTORY_SEPARATOR . $path);

if ($currentDir && strpos($currentDir, $baseDir) === 0) {
    $newFolderPath = $currentDir . DIRECTORY_SEPARATOR . $folder;
    if (!file_exists($newFolderPath)) {
        mkdir($newFolderPath, 0755, true);
    }
}

header("Location: admin.php?path=" . urlencode($path));
exit;

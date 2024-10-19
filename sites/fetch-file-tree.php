<?php
header('Content-Type: application/json');

$folder = isset($_GET['folder']) ? $_GET['folder'] : '.';
$files = scandir($folder);
$fileArray = [];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }

    $filePath = $folder . '/' . $file;
    $type = is_dir($filePath) ? 'folder' : 'file';

    $fileArray[] = [
        'name' => $file,
        'type' => $type,
        'path' => $filePath,
    ];
}

echo json_encode($fileArray);

?>
<?php
// Set repository root
$baseDir = realpath(__DIR__ . '/filegator/repository');

// Get requested path
$requested = $_GET['path'] ?? '';
$requested = trim($requested, '/');

// Build full path safely
$path = realpath($baseDir . '/' . $requested);

// Security check: block access outside repository
if (!$path || strpos($path, $baseDir) !== 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid path']);
    exit;
}

// Scan directory
$items = [];
foreach (scandir($path) as $item) {
    if ($item === '.' || $item === '..') continue;

    $fullPath = $path . '/' . $item;
    $isDir = is_dir($fullPath);

    $items[] = [
        'name' => $item,
        'type' => $isDir ? 'folder' : 'file',
        'path' => str_replace($baseDir . '/', '', $fullPath)
    ];
}

header('Content-Type: application/json');
echo json_encode($items);

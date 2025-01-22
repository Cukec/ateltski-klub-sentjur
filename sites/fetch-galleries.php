<?php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 4;
$offset = ($page - 1) * $limit;

$baseDir = '../filegator/repository/galerija/';
$folders = array_filter(glob($baseDir . '*'), 'is_dir');
$totalGalleries = count($folders);
$folders = array_slice($folders, $offset, $limit);

$galleries = [];
foreach ($folders as $folder) {
    $images = array_filter(glob($folder . '/*'), function ($file) {
        return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
    });

    $galleries[] = [
        'title' => basename($folder),
        'id' => md5($folder), // Generate unique ID
        'images' => array_map(function ($image) {
            return [
                'url' => str_replace('../', '/', $image),
                'alt' => basename($image),
            ];
        }, $images),
    ];
}

header('Content-Type: application/json');
echo json_encode([
    'galleries' => $galleries,
    'totalGalleries' => $totalGalleries,
]);

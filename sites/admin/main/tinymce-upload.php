<?php
// --- CONFIG ---
$uploadDir = realpath(__DIR__ . '/../../../gallery/tinymce') . '/'; // save path on disk
$uploadUrl = '../gallery/tinymce/'; // path used in <img src="..."> in TinyMCE content

$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

// --- CHECK FILE ---
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded or upload error']);
    exit;
}

$file = $_FILES['file'];

if (!in_array($file['type'], $allowedTypes)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid file type']);
    exit;
}

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// --- FILENAME & PATH ---
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('img_') . '.' . $ext;
$targetPath = $uploadDir . $filename;

// --- IMAGE RESIZE ---
list($width, $height) = getimagesize($file['tmp_name']);
$aspectRatio = $width / $height;

if ($aspectRatio > 1.5) {
    $newWidth = 640;
    $newHeight = 360;
} elseif ($aspectRatio < 0.66) {
    $newWidth = 360;
    $newHeight = 640;
} else {
    $newWidth = $newHeight = 360;
}

switch ($file['type']) {
    case 'image/jpeg': $src = imagecreatefromjpeg($file['tmp_name']); break;
    case 'image/png':  $src = imagecreatefrompng($file['tmp_name']); break;
    case 'image/webp': $src = imagecreatefromwebp($file['tmp_name']); break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unsupported image type']);
        exit;
}

$dst = imagecreatetruecolor($newWidth, $newHeight);
imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

// --- SAVE TO DISK ---
switch ($file['type']) {
    case 'image/jpeg': imagejpeg($dst, $targetPath, 85); break;
    case 'image/png':  imagepng($dst, $targetPath); break;
    case 'image/webp': imagewebp($dst, $targetPath, 85); break;
}

imagedestroy($src);
imagedestroy($dst);

// --- RETURN TO TINYMCE ---
echo json_encode([
    'location' => $uploadUrl . $filename
]);

<?php
$base_upload_dir = 'uploads/';

// Ensure the uploads directory exists
if (!is_dir($base_upload_dir)) {
    mkdir($base_upload_dir, 0777, true);
}

// Check if folder name is received
if (!isset($_POST['folderName'])) {
    die("No folder name provided.");
}

$folder_name = preg_replace("/[^a-zA-Z0-9_-]/", "_", $_POST['folderName']); // Sanitize folder name
$upload_dir = $base_upload_dir . $folder_name . '/';

// Create the specific folder inside 'uploads/'
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Check if files were uploaded
if (!isset($_FILES['images'])) {
    die("No files uploaded.");
}

$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
    if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) {
        echo "Error uploading file: " . $_FILES['images']['name'][$index] . "<br>";
        continue;
    }

    // Validate file type
    $file_type = $_FILES['images']['type'][$index];
    if (!in_array($file_type, $allowed_types)) {
        echo "Invalid file type: " . $_FILES['images']['name'][$index] . "<br>";
        continue;
    }

    // Get relative folder structure from webkitRelativePath
    $original_path = $_FILES['images']['name'][$index]; // Corrects webkitRelativePath issue
    $relative_path = preg_replace("/[^a-zA-Z0-9_\/.-]/", "_", $original_path); // Sanitize

    // Create nested subfolders if needed
    $save_path = $upload_dir . $relative_path;
    $save_folder = dirname($save_path);

    if (!is_dir($save_folder)) {
        mkdir($save_folder, 0777, true);
    }

    // Resize and save image
    resizeImage($tmp_name, $save_path, 800);

    echo "Uploaded & resized: " . $_FILES['images']['name'][$index] . "<br>";
}

// Function to resize images
function resizeImage($source, $destination, $new_width) {
    list($width, $height, $type) = getimagesize($source);
    $new_height = ($height / $width) * $new_width;

    // Create image resource based on type
    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($source);
            break;
        case IMAGETYPE_GIF:
            $src = imagecreatefromgif($source);
            break;
        default:
            die("Unsupported image type.");
    }

    // Create a new blank image
    $dst = imagecreatetruecolor($new_width, $new_height);

    // Maintain transparency for PNG & GIF
    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
        imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
    }

    // Resize and save image
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($dst, $destination, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($dst, $destination, 8);
            break;
        case IMAGETYPE_GIF:
            imagegif($dst, $destination);
            break;
    }

    // Free memory
    imagedestroy($src);
    imagedestroy($dst);
}

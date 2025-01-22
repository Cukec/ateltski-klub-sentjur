<?php

// Include the database connection config
include 'config.php';

// Define the root directory where images are stored
$rootDir = '../filegator/repository';

// Function to recursively get all image URLs
function getImageUrls($dir, $rootDir) {
    $imageUrls = [];

    // Open the directory
    $files = scandir($dir);

    foreach ($files as $file) {
        // Skip current and parent directory
        if ($file == '.' || $file == '..') {
            continue;
        }

        $filePath = $dir . '/' . $file;

        // If it's a directory, recursively scan it
        if (is_dir($filePath)) {
            $imageUrls = array_merge($imageUrls, getImageUrls($filePath, $rootDir)); // Merge results from subdirectories
        } else {
            // If it's an image file, add the URL
            if (preg_match('/\.(jpg|jpeg|png|gif|bmp)$/i', $file)) {
                $imageUrls[] = str_replace($rootDir . '/', '', $filePath);
            }
        }
    }

    return $imageUrls;
}

// Get all image URLs from the repository
$imageUrls = getImageUrls($rootDir, $rootDir);

// Fetch the latest upload_datetime from the database
$query = "SELECT MAX(upload_datetime) AS latest_upload FROM test_image";
$result = $conn->query($query);

if ($result) {
    $latestUploadRow = $result->fetch_assoc();
    $latestUpload = $latestUploadRow['latest_upload'];
} else {
    die("Error fetching latest upload: " . $conn->error);
}

// Filter images based on the latest upload datetime
$newImages = [];
foreach ($imageUrls as $url) {
    $fileUploadTime = filemtime($rootDir . '/' . $url); // Gets the file's last modified time

    // Check if the image was modified after the latest upload
    if (!$latestUpload || strtotime($latestUpload) < $fileUploadTime) {
        $newImages[] = $url;
    }
}

// Insert new images into the database
if (!empty($newImages)) {
    $stmt = $conn->prepare("INSERT INTO test_image (url, upload_datetime) VALUES (?, NOW())");

    foreach ($newImages as $url) {
        $stmt->bind_param("s", $url);
        $stmt->execute();
    }

    echo "Uploaded " . count($newImages) . " new images.";
} else {
    echo "No new images found or uploaded.";
}

?>

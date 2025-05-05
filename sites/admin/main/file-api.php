<?php

$baseDir = 'uploads';  // Base directory for file uploads
$action = $_GET['action'] ?? '';

// Handle file upload
if ($action === 'upload') {
    $path = $_POST['path'] ?? $baseDir;
    if (!is_dir($path)) {
        mkdir($path, 0755, true);  // Create the directory if it doesn't exist
    }

    foreach ($_FILES['files']['name'] as $index => $name) {
        $tmpName = $_FILES['files']['tmp_name'][$index];
        $filename = basename($name);
        move_uploaded_file($tmpName, $path . DIRECTORY_SEPARATOR . $filename);  // Move the uploaded file
    }

    echo json_encode(['success' => true]);  // Return success
    exit;
}

// Load the files in a directory
if ($action === 'loadFiles') {
    $path = $_GET['path'] ?? $baseDir;
    if (!is_dir($path)) {
        echo json_encode(['error' => 'Directory not found']);
        exit;
    }

    $files = array_diff(scandir($path), array('..', '.'));
    echo json_encode($files);  // Return a list of files
    exit;
}

?>

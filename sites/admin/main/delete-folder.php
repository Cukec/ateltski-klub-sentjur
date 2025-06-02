<?php
$galleryDir = '../../../gallery/galerija/';
$data = json_decode(file_get_contents("php://input"), true);

$folder = basename($data['folder'] ?? '');
$response = ['success' => false];

if ($folder) {
    $fullPath = $galleryDir . $folder;

    if (is_dir($fullPath)) {
        // Delete files inside
        $files = glob("$fullPath/*");
        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }

        if (rmdir($fullPath)) {
            $response['success'] = true;
        } else {
            $response['message'] = "Mapa ni bila izbrisana.";
        }
    } else {
        $response['message'] = "Mapa ne obstaja.";
    }
} else {
    $response['message'] = "Neveljavno ime mape.";
}

echo json_encode($response);

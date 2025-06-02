<?php
$galleryDir = '../../../gallery/galerija/';
$data = json_decode(file_get_contents("php://input"), true);

$old = basename($data['oldName'] ?? '');
$new = basename($data['newName'] ?? '');

$response = ['success' => false];

if ($old && $new && $old !== $new) {
    $oldPath = $galleryDir . $old;
    $newPath = $galleryDir . $new;

    if (is_dir($oldPath) && !file_exists($newPath)) {
        if (rename($oldPath, $newPath)) {
            $response['success'] = true;
        } else {
            $response['message'] = "Preimenovanje ni uspelo.";
        }
    } else {
        $response['message'] = "Mapa ne obstaja ali novo ime že obstaja.";
    }
} else {
    $response['message'] = "Neveljavno ime.";
}

echo json_encode($response);

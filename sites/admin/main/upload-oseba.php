<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && isset($_POST['id_osebe'])) {
    $id = intval($_POST['id_osebe']);
    $targetDir = '../../../gallery/osebje/';
    $targetPath = $targetDir . $id . '.jpg';

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0775, true); // Ustvari mapo če ne obstaja
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        http_response_code(200);
        echo "Uspešno naloženo.";
    } else {
        http_response_code(500);
        echo "Napaka pri nalaganju slike.";
    }
} else {
    http_response_code(400);
    echo "Neveljavna zahteva.";
}
?>

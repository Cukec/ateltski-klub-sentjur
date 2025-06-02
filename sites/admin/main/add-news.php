<?php
require_once '../../config.php';

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

$msg = "";
$error = "flase";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title']);
    $content = sanitizeInput($_POST['content']);
    $shown = (int) $_POST['shown']; // Ensure it's an integer
    $id_admin = 1; // Default admin ID

    $stmt = $conn->prepare("INSERT INTO news (title, content, shown, id_admin) VALUES (?, ?, ?, ?)");
    $success = $stmt->execute([$title, $content, $shown, $id_admin]);

    if ($success) {
        //echo "News added successfully!";
        $msg = "Uspešno dodajanje vsebine!";
        
    } else {
        //echo "Error adding news.";
        $msg = "Napaka pri dodajanju vsebine! Poskusite znova...";
        $error = "true";
    }
} else {
    $msg = "Napaka pri pošiljanju podatkov! Poskusite znova...";
    $error = "true";
}

header("location: admin.php?status_msg=" . urlencode($msg) ."&error=" . urlencode($error));

exit;
?>

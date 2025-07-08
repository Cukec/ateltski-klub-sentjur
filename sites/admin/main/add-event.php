<?php
require_once '../../config.php';

function sanitizeInput($input) {
    return trim($input); // HTML escapanje ni potrebno pri vnosu v bazo
}

$msg = "";
$error = "false";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Osnovna validacija
    $title = sanitizeInput($_POST['title'] ?? '');
    $content = sanitizeInput($_POST['content'] ?? '');
    $location = sanitizeInput($_POST['location'] ?? '');
    $date_start = $_POST['date_start'] ?? null;
    $date_end = $_POST['date_end'] ?? null;
    $type = $_POST['type'] ?? '';
    $id_admin = 1;

    // Priprava in izvedba poizvedbe
    $stmt = $conn->prepare("INSERT INTO events (type, title, content, location, date_start, date_end, id_admin) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $success = $stmt->execute([$type, $title, $content, $location, $date_start, $date_end, $id_admin]);

    if ($success) {
        $msg = "Uspešno posodabljanje vsebine!";
    } else {
        $msg = "Napaka pri posodabljanju vsebine! Poskusite znova...";
        $error = "true";
    }
}

header("location: admin.php?status_msg=" . urlencode($msg) . "&error=" . urlencode($error));
exit;
?>

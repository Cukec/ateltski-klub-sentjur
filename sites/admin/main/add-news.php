<?php
require_once '../../config.php';

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

$msg = "";
$error = "false";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? sanitizeInput($_POST['title']) : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $shown = isset($_POST['shown']) ? (int) $_POST['shown'] : 0;
    $type = isset($_POST['type']) ? sanitizeInput($_POST['type']) : null;  // optional
    $id_admin = 1; // example fixed admin ID
    $id_image = isset($_POST['id_image']) ? (int) $_POST['id_image'] : null;     // optional
    $id_image_2 = isset($_POST['id_image_2']) ? (int) $_POST['id_image_2'] : null; // optional

    // Basic validation
    if (empty($title) || empty(trim(strip_tags($content)))) {
        $msg = "Naslov in vsebina ne smeta biti prazna.";
        $error = "true";
    } else {
        // Use current datetime for post_time
        $post_time = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("
            INSERT INTO news
                (title, content, shown, post_time, type, id_admin, id_image, id_image_2)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $success = $stmt->execute([
            $title,
            $content,
            $shown,
            $post_time,
            $type,
            $id_admin,
            $id_image,
            $id_image_2
        ]);

        if ($success) {
            $msg = "Uspešno dodajanje vsebine!";
        } else {
            $msg = "Napaka pri dodajanju vsebine! Poskusite znova...";
            $error = "true";
            //$errorInfo = $stmt->errorInfo();
            file_put_contents('db_error.log', print_r($errorInfo, true), FILE_APPEND);
        }
    }
} else {
    $msg = "Napaka pri pošiljanju podatkov! Poskusite znova...";
    $error = "true";
}

header("Location: admin.php?status_msg=" . urlencode($msg) . "&error=" . urlencode($error));
exit;
?>

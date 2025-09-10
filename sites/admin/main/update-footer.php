<?php
require_once '../../config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $column = $_POST['column'];
    $value = $_POST['value'];

    // Whitelist columns to avoid SQL injection
    $allowed = ['street', 'post', 'contact_person', 'tel', 'mail', 'tax_number', 'tax_note', 'trr', 'bank', 'other'];
    if (!in_array($column, $allowed)) {
        http_response_code(400);
        echo 'Invalid column';
        exit;
    }

    $stmt = $conn->prepare("UPDATE footer SET `$column` = ? LIMIT 1");
    $stmt->bind_param("s", $value);
    if ($stmt->execute()) {
        echo 'Updated';
    } else {
        http_response_code(500);
        echo 'Error updating';
    }
}

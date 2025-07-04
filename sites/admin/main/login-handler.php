<?php
require_once '../../config.php';

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (authenticate($username, $password)) {
        echo json_encode(['success' => true]);
    } else {
        $_SESSION['logged_in'] = false;
        echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method.']);

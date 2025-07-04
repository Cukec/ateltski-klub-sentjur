<?php
require_once '../../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Vsa polja so obvezna.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Uporabniško ime že obstaja.']);
        exit;
    }
    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admini (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Admin uspešno dodan!',
            'newUsername' => $username,
            'newId' => $stmt->insert_id
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Napaka pri dodajanju admina.']);
    }

    $stmt->close();
}

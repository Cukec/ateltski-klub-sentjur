<?php
require '../../config.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data['id']);
$field = $data['field'];
$value = $data['value'];

// Dovoli le urejanje teh polj
$allowed = ['age', 'location', 'schedule', 'town', 'note'];
if (!in_array($field, $allowed)) {
    echo json_encode(['success' => false, 'message' => 'Neveljavno polje']);
    exit;
}

// Uporabi pripravljeno izjavo
$stmt = $conn->prepare("UPDATE practices SET $field = ? WHERE id = ?");
$stmt->bind_param("si", $value, $id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);

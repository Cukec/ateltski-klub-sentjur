<?php
require '../../config.php';
$data = json_decode(file_get_contents("php://input"), true);
$stmt = $conn->prepare("UPDATE team_members SET {$data['field']} = ? WHERE id = ?");
$stmt->bind_param("si", $data['value'], $data['id']);
$stmt->execute();

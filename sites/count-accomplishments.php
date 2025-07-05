<?php
require_once 'config.php';

$result = $conn->query("SELECT COUNT(*) as total FROM accomplishments WHERE is_club_acc = 1");
$data = $result->fetch_assoc();

echo json_encode(['total' => (int)$data['total']]);

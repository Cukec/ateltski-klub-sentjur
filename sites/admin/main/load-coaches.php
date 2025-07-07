<?php
require '../../config.php';

$sql = "SELECT c.id, p.name, p.surname
        FROM coach c
        JOIN people p ON c.id = p.id";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>

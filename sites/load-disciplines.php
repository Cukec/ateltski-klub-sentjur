<?php
require_once 'config.php';

$query = "SELECT id, title FROM discipline ORDER BY num_out ASC";
$result = $conn->query($query);

$disciplines = [];
while ($row = $result->fetch_assoc()) {
    $disciplines[] = [
        'id' => $row['id'],
        'title' => $row['title']
    ];
}

header('Content-Type: application/json');
echo json_encode($disciplines);

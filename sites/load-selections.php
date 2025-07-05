<?php
require_once 'config.php';

$query = "SELECT id, title FROM selection ORDER BY title ASC";
$result = $conn->query($query);

$selections = [];
while ($row = $result->fetch_assoc()) {
    $selections[] = [
        'id' => $row['id'],
        'title' => $row['title']
    ];
}

header('Content-Type: application/json');
echo json_encode($selections);

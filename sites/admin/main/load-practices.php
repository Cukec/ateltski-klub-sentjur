<?php
require '../../config.php';

$sql = "SELECT pr.id, pr.age, pr.location, pr.schedule, pr.town, pr.note, 
        CONCAT(p.surname, ' ', p.name) AS coach_name
        FROM practices pr
        JOIN coach c ON pr.id_coach = c.id
        JOIN people p ON c.id = p.id
        ORDER BY pr.id DESC";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>

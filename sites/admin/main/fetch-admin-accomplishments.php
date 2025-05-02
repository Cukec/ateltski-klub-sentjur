<?php
require_once '../../config.php'; // Adjust the path to your database connection

header('Content-Type: application/json');

$sql = "SELECT a.*, 
            LEFT(a.description, 20) AS descript, 
            p.name, p.surname, p.gender, 
            s.title AS selection_title, 
            d.title AS discipline_title 
        FROM accomplishments a
        LEFT JOIN people p ON a.id_people = p.id
        LEFT JOIN selection s ON a.id_selection = s.id
        LEFT JOIN discipline d ON a.id_discipline = d.id
        ORDER BY a.date DESC";

$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'date' => $row['date'],
            'fullname' => $row['name'] . " " . $row['surname'],
            'selection' => $row['selection_title'],
            'discipline' => $row['discipline_title'],
            'result_technical' => $row['result_technical'],
            'result_time' => $row['result_time'],
            'description' => $row['descript'] . "...",
            'location' => $row['location'],
            'gender' => $row['gender']
        ];
    }
}

echo json_encode($data);
?>
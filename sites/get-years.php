<?php
include "config.php";

$sql = "SELECT DISTINCT YEAR(date) as year FROM accomplishments WHERE is_club_acc = 1 ORDER BY year DESC";
$result = $conn->query($sql);

$years = [];
while ($row = $result->fetch_assoc()) {
    $years[] = $row['year'];
}

header('Content-Type: application/json');
echo json_encode($years);
?>

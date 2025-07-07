<?php
require '../../config.php';

$stmt = $conn->prepare("INSERT INTO practices (id_coach, age, location, schedule, town, note) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $_POST['id_coach'], $_POST['age'], $_POST['location'], $_POST['schedule'], $_POST['town'], $_POST['note']);
$stmt->execute();

echo "Trening uspešno dodan.";
?>

<?php

include('../../config.php');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$type = isset($_POST['type']) ? (int)$_POST['type'] : 0;

if (empty($title) || $id <= 0) {
    die("Napaka: manjka naslov ali neveljaven ID.");
}

$stmt = $conn->prepare("UPDATE discipline SET title = ?, type = ? WHERE id = ?");
$stmt->bind_param("sii", $title, $type, $id);

if ($stmt->execute()) {
    echo "USPEŠNO posodobljena disciplina.";
} else {
    echo "NAPAKA pri posodabljanju discipline: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<?php

include('../../config.php');

$msgs = [];
$error = "false";

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$type = isset($_POST['type']) ? (int)$_POST['type'] : 0;

if (empty($title) || $id <= 0) {
    die("Napaka: manjka naslov ali neveljaven ID.");
}

$stmt = $conn->prepare("UPDATE discipline SET title = ?, type = ? WHERE id = ?");
$stmt->bind_param("sii", $title, $type, $id);

if ($stmt->execute()) {
    $msgs[] = "Uspešno posodobljena disciplina!";
} else {
    $msgs[] = "Napaka pri posodabljanju discipline!";
}

$stmt->close();
$conn->close();

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));

?>

<?php

include("../../config.php");

$msgs = [];
$error = "false";

$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if (empty($title) || $id <= 0) {
    die("Napaka: Manjkajoče ali napačne vrednosti.");
}

$sql = "UPDATE selection SET title = ? WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $title, $id);

if ($stmt->execute()) {
    $msgs[] = "Uspešno posodabljanje selekcije!";
} else {
    $msgs[] = "Napaka pri posodabljanju selekcije!";
}

$conn->close();

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));

?>

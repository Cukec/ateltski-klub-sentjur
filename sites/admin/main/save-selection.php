<?php

include("../../config.php");

$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if (empty($title) || $id <= 0) {
    die("Napaka: Manjkajoče ali napačne vrednosti.");
}

$sql = "UPDATE selection SET title = ? WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $title, $id);

if ($stmt->execute()) {
    echo "USPEŠNO posodabljanje selekcije!";
} else {
    echo "NAPAKA pri posodabljanju selekcije!";
}

$conn->close();

?>

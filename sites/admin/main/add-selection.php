<?php

include("../../config.php");

$msgs = [];
$error = "false";

$title = isset($_POST['title']) ? trim($_POST['title']) : '';

if (empty($title)) {
    die("Napaka: Polje naziva ne sme biti prazno.");
}

$sql = "INSERT INTO selection (title) VALUES (?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $title);

if ($stmt->execute()) {
    $msgs[] = "Uspešno dodajanje nove selekcije!";
} else {
    $msgs[] = "Napaka pri dodajanju nove selekcije!";
}

$conn->close();

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));

?>

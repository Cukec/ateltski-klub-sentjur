<?php

include("../../config.php");

$title = isset($_POST['title']) ? trim($_POST['title']) : '';

if (empty($title)) {
    die("Napaka: Polje naziva ne sme biti prazno.");
}

$sql = "INSERT INTO selection (title) VALUES (?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $title);

if ($stmt->execute()) {
    echo "USPEŠNO dodajanje nove selekcije!";
} else {
    echo "NAPAKA pri dodajanju nove selekcije!";
}

$conn->close();

?>

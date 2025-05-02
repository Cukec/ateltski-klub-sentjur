<?php
include 'config.php'; // Vključi povezavo do baze

$newsId = $_GET['id'];

// Pripravite poizvedbo za pridobitev podatkov o novici
$stmt = $conn->prepare("SELECT id, title, content FROM news WHERE id = ?");
$stmt->bind_param("i", $newsId);
$stmt->execute();
$stmt->bind_result($id, $title, $content);
$stmt->fetch();

// Vrnite podatke v JSON obliki
echo json_encode(array('id' => $id, 'title' => $title, 'content' => $content));

$stmt->close();
$conn->close();
?>

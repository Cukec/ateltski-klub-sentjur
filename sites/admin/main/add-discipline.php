<?php

include('../../config.php');

$msgs = [];
$error = "false";

// Get the current highest value
$query = "SELECT MAX(num_out) AS max_num_out FROM discipline";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Increment it by 1 (or default to 1 if no rows exist)
$newPosition = ($row['max_num_out'] !== null) ? $row['max_num_out'] + 1 : 1;

$title = isset($_POST['title']) ? trim($_POST['title']) : '';

$stmt = $conn->prepare("INSERT INTO discipline (title, type, num_out) VALUES (?,?,?)");
$stmt->bind_param("sii", $title, $_POST['type'], $newPosition);

if (empty($title)) {
    die("Title is required.");
}

if($stmt->execute()){

    $msgs[] = "Uspešno dodajanje nove discipline!";

}else{

    $msgs[] = "Napaka pri dodajanju nove discipline!";
    
}

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));

?>
<?php
include 'config.php';

// Get form data
$title = $_POST['title'];
$content = $_POST['content'];
$shown = $_POST['shown'];
$post_time = $_POST['post_time'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO news (title, content, shown, post_time, id_admin) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssisi", $title, $content, $shown, $post_time, $id_admin);

// Example: set id_admin to 1 (change this to the actual admin ID if needed)
$id_admin = 1;

// Execute the statement
if ($stmt->execute()) {
    echo "New news added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect back to the homepage or display a success message
header("Location: domov.php");
exit();
?>

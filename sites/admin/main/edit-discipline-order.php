<?php
require_once '../../config.php'; // adjust path to your config/DB connection

if (!isset($_POST['order'])) {
    exit("No order received");
}

$order = $_POST['order'];

$stmt = $conn->prepare("UPDATE discipline SET num_out = ? WHERE id = ?");

foreach ($order as $item) {
    $stmt->bind_param("ii", $item['position'], $item['id']);
    $stmt->execute();
}

echo "Vrstni red posodobljen!";

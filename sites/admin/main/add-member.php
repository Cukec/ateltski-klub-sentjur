<?php
require '../../config.php'; // adjust path as needed

$data = json_decode(file_get_contents("php://input"), true);

// Validate
if (!isset($data['name'], $data['surname'], $data['function'])) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

// Get next display order
$result = $conn->query("SELECT MAX(display_order) AS max_order FROM team_members");
$row = $result->fetch_assoc();
$next_order = $row['max_order'] + 1;

// Insert new member
$stmt = $conn->prepare("INSERT INTO team_members (name, surname, function, display_order)
                        VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $data['name'], $data['surname'], $data['function'], $next_order);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Database insert failed.";
}


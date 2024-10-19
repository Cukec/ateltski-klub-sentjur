<?php
// Database configuration
$host = 'localhost';  // Your database server, usually 'localhost'
$dbname = 'ak-sentjur-test';  // Replace with your actual database name
$username = 'root';  // Replace with your actual username
$password = '';  // Replace with your actual password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the charset to utf8mb4 for proper encoding
$conn->set_charset("utf8mb4");

?>

<?php
$host = 'localhost';  
$dbname = 'ak-sentjur-test';  
$username = 'root';  
$password = '';  

session_start();

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

function authenticate($username, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    if (!$stmt) return false;

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }

    return false;
}

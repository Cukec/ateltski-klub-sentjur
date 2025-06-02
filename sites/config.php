<?php
$host = 'localhost';  
$dbname = 'ak-sentjur-test';  
$username = 'root';  
$password = '';  

session_start();

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the charset to utf8mb4 for proper encoding
$conn->set_charset("utf8mb4");

// Admin logged status
if (!isset($_SESSION['admin_logged'])) {
    $_SESSION['admin_logged'] = false;
}

// Check if the page needs the admin check (for example, a page like admin-dashboard.php)
$is_admin_page = isset($check_admin) && $check_admin;

if ($is_admin_page && $_SESSION['admin_logged'] === false) {
    // If the admin is not logged in, set a flag to hide the body content
    $hide_body = true;
} else {
    $hide_body = false;
}

function authenticate($username, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    if (!$stmt) return false;

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            session_start(); // Ensure session is started
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_id'] = $user['id']; // Fixed typo: 'addmin_id' -> 'admin_id'
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }

    return false;
}



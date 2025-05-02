<?php

$host = 'localhost';  
$dbname = 'ak-sentjur';  
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


abstract class CMS{    

    abstract public function add(array $data);
    abstract public function change(int $id, array $data);
    abstract public function delete(int $id);

    protected function sanitizeInput($input) {
        return trim($input);
    }

    protected function validateSQL($input) {
        return preg_match('/(union|select|insert|delete|update|drop|--)/i', $input) ? false : true;
    }

}

?>
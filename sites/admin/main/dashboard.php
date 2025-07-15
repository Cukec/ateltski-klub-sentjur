<?php
require_once '../../config.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Dashboard</title></head>
<body>
    <h1>Welcome, <?=htmlspecialchars($_SESSION['admin_username'])?></h1>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>

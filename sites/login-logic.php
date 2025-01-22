<?php
// Include database connection
require_once 'config.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from the form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare and execute the query
    if ($stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?")) {
        $stmt->bind_param('s', $username); // Bind the username parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            // Compare the plaintext password directly
            if ($password === $user['password']) {
                // Password is correct, start a session
                session_start();
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to the dashboard
                header("Location: admin.php");
                exit;
            } else {
                echo "<script>alert('Invalid username or password!');</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password!');</script>";
        }

        $stmt->close();
    } else {
        die("Statement preparation failed: " . $conn->error);
    }
}
?>

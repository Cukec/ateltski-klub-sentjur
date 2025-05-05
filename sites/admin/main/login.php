<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if ($user === 'admin' && $pass === 'yourpassword') {
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" required placeholder="Username"><br><br>
        <input type="password" name="password" required placeholder="Password"><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>

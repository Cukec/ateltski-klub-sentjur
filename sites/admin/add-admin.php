<?php
require_once '../config.php';  // assumes $conn MySQLi connection and session_start()

// Your secret access key (change this to something secure!)
define('ACCESS_KEY', 'MySuperSecretKey123');

// Check access key
$key = $_GET['key'] ?? '';
if ($key !== ACCESS_KEY) {
    http_response_code(403);
    exit('Access denied.');
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['mail'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$email || !$password) {
        $message = "All fields are required.";
    } else {
        // Hash password (use password_hash, so password column must be longer than 45 chars)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert admin into DB
        $stmt = $conn->prepare("INSERT INTO admin (username, password, mail) VALUES (?, ?, ?)");
        if (!$stmt) {
            $message = "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param('sss', $username, $hashedPassword, $email);
            if ($stmt->execute()) {
                $message = "Admin added successfully!";
            } else {
                // Handle duplicate usernames/emails gracefully
                if ($conn->errno === 1062) {
                    $message = "Username or email already exists.";
                } else {
                    $message = "Error: " . $conn->error;
                }
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Add Admin</title></head>
<body>
<h2>Add Admin</h2>

<?php if ($message): ?>
<p><?=htmlspecialchars($message)?></p>
<?php endif; ?>

<form method="post">
    <label>Username:<br>
        <input type="text" name="username" required maxlength="45">
    </label><br><br>
    <label>Email:<br>
        <input type="email" name="mail" required maxlength="45">
    </label><br><br>
    <label>Password:<br>
        <input type="password" name="password" required>
    </label><br><br>
    <button type="submit">Add Admin</button>
</form>

<p><small>Access protected by key in URL. Example: <code>add_admin.php?key=MySuperSecretKey123</code></small></p>
</body>
</html>

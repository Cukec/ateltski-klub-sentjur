<?php
require_once '../../config.php'; // povezava z bazo

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST['password'];


    // Hashiranje gesla
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Vstavi v bazo
    $stmt = $conn->prepare("INSERT INTO admin (username, mail, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Admin uspešno dodan.";
    } else {
        echo "Napaka pri dodajanju admina: " . $stmt->error;
    }
    $stmt->close();
}

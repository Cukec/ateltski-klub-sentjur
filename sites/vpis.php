<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin vpis</title>
	<link rel="stylesheet" href="styles/vpis.css">
    <style>
       
    </style>
</head>
<body>

<?php include"navigation.php"; include"config.php" ?>

<div class="login-box">
  <h2>Vpis</h2>
  <form action="login-logic.php" method="POST">
    <div class="user-box">
        <input type="text" name="username" required>
        <label>Uporabniško ime</label>
    </div>
    <div class="user-box">
        <input type="password" name="password" required>
        <label>Geslo</label>
    </div>
    <button type="submit">Vpis</button>
</form>

</div>
</body>
</html>
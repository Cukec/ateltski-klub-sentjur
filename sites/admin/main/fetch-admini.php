<?php
require_once '../../config.php'; // povezava z bazo

$sql = "SELECT id, username, mail FROM admin";
$result = $conn->query($sql);

echo "<h2>Seznam adminov:</h2>";
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li><strong>{$row['username']}</strong> ({$row['mail']})</li>";
}
echo "</ul>";

// Forma za dodajanje novega admina
?>
<h3 style="margin: 1vh 0; align-items: middle; justify-content: middle;">Dodaj novega admina</h3>
<form style="display: flex; flex-direction: row;" id="dodaj-admin-form">
    
    <input type="text" name="username" placeholder="Uporabniško ime" required>
    

    <input type="email" name="email" placeholder="E-pošta" required>

    <input type="password" name="password" placeholder="Geslo" required>

    <button type="submit" style="margin-top: 1vh">Dodaj admina</button>
</form>

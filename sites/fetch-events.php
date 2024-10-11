<?php
// Database connection details (adjust these)
$host = 'localhost';
$dbname = 'ak-sentjur';
$user = 'root';
$pass = 'npGLmd8#v*=Ek"76jy>4';

try {
    // Establish a connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set the Content-Type to JSON
    header('Content-Type: application/json');

    // Query to fetch events from the database and alias date_start as start
    $stmt = $pdo->query("SELECT title, date_start AS start FROM events");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the events as JSON
    echo json_encode($events);

} catch (PDOException $e) {
    // Return error message in case of an exception
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>

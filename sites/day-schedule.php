<?php
require_once 'config.php'; // contains $conn = new mysqli(...);

// Get the selected date from the query string
$selectedDate = $_GET['date'] ?? '';
$safeDate = htmlspecialchars($selectedDate);

// Format to Slovenian date format
$slovenianDate = '';
if ($selectedDate) {
    $timestamp = strtotime($selectedDate);
    if ($timestamp !== false) {
        $slovenianDate = date("d.m.Y", $timestamp); // DD.MM.YYYY
    }
}

$title = '';
$content = '';
$location = '';

if ($selectedDate) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT title, content, location FROM events WHERE date_start = ?");
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $stmt->bind_result($title, $content, $location);
    $stmt->fetch();
    $stmt->close();
}


?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Dnevni razpored</title>
    <link rel="stylesheet" href="styles/schedule.css">
</head>
<body>
<?php include "navigation.php" ?>
<main>
    <h1>Dnevni razpored dne <?= $slovenianDate ?></h1>

    <?php if ($safeDate): ?>
        <?php if ($title): ?>
            <div class="event-box">
                <h2>
                    <?= $title ?>
                    <span style="color: #ccc; font-size: 0.9em;">
                        <?= $location ?>
                    </span>
                </h2>
                <hr>
                <p><?= $content ?></p>
            </div>
        <?php else: ?>
            <p>Ni dogodkov za ta dan.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Datum ni izbran.</p>
    <?php endif; ?>
    <div class="go-back">
        <a href="dogodki.php">nazaj ↶</a>
    </div>
</main>
<?php include "footer.php"?>
</body>
</html>

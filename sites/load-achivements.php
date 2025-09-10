<?php
require_once 'config.php';

$year = isset($_GET['year']) && $_GET['year'] !== 'all' ? (int)$_GET['year'] : null;

if ($year) {
    // Filter by a specific year
    $query = "SELECT YEAR(a.date) AS year, a.description, p.name, p.surname
              FROM accomplishments a
              JOIN people p ON a.id_people = p.id
              WHERE a.is_club_acc = 1 AND YEAR(a.date) = ?
              ORDER BY a.date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $year);
} else {
    // Get all years
    $query = "SELECT YEAR(a.date) AS year, a.description, p.name, p.surname
              FROM accomplishments a
              JOIN people p ON a.id_people = p.id
              WHERE a.is_club_acc = 1
              ORDER BY year DESC, a.date DESC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

$currentYear = null;
?>
<link rel="stylesheet" href="accomplishments.css">

<div class="achievements">
<?php
// If filtering by year, show heading immediately
if ($year) {
    echo "<h3>{$year}:</h3><ul>";
}

while ($row = $result->fetch_assoc()) {
    $rowYear     = isset($row['year']) ? (int)$row['year'] : '';
    $name        = isset($row['name']) ? htmlspecialchars($row['name']) : '';
    $surname     = isset($row['surname']) ? htmlspecialchars($row['surname']) : '';
    $description = isset($row['description']) ? htmlspecialchars($row['description']) : '';

    if ($rowYear === '' || ($name === '' && $surname === '') || $description === '') {
        continue;
    }

    if (!$year && $rowYear !== $currentYear) {
        if ($currentYear !== null) {
            echo "</ul>";
        }
        echo "<h3>{$rowYear}:</h3><ul>";
        $currentYear = $rowYear;
    }

    echo "<li><strong>{$name} {$surname}</strong> – {$description}</li>";
}

echo "</ul>";
?>
</div>
<?php
$stmt->close();
$conn->close();
?>

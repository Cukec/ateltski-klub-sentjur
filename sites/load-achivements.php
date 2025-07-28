<?php
require_once 'config.php';

$year = isset($_GET['year']) && $_GET['year'] !== 'all' ? (int)$_GET['year'] : null;

if ($year) {
    // Get results for a specific year
    $query = "SELECT id, description, date, location 
              FROM accomplishments 
              WHERE is_club_acc = 1 AND YEAR(date) = ? 
              ORDER BY date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $year);
} else {
    // Get all results
    $query = "SELECT id, description, date, location 
              FROM accomplishments 
              WHERE is_club_acc = 1 
              ORDER BY date DESC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $description = htmlspecialchars($row['description']);
    $location = empty($row['location'])
    ? '<i style="color: #888;">Lokacije ni navedene</i>'
    : htmlspecialchars($row['location']);

    $date = date("Y", strtotime($row['date']));

    // Truncate description without cutting mid-word
    if (strlen($description) > 150) {
        $truncated = substr($description, 0, 150);
        $truncated = preg_replace('/\s+\S*$/', '', $truncated);
        $truncated .= '...';
    } else {
        $truncated = $description;
    }
    ?>
    <div class="acc">
        <p><strong><?= $location ?></strong> | <em><?= $date ?></em></p>
        <hr>
        <p><?= $truncated ?></p>
        <a href="info-dosezek.php?id=<?= $id ?>">
            <button class="read-more-btn">Preberi več</button>
        </a>
    </div>
    <?php
}
?>

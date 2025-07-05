<?php
require_once 'config.php'; // ali tvoja datoteka za povezavo na bazo

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 8;
$offset = ($page - 1) * $perPage;

$query = "SELECT id, description, date, location FROM accomplishments WHERE is_club_acc = 1 ORDER BY date DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $offset, $perPage);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $id = $row['id']; // dodano
    $description = htmlspecialchars($row['description']);
    $location = htmlspecialchars($row['location']);
    $date = date("j. n. Y", strtotime($row['date'])); // slovenski format

    // Odrežemo description na 150 znakov brez rezanja besede
    if (strlen($description) > 150) {
        $truncated = substr($description, 0, 150);
        $truncated = preg_replace('/\s+\S*$/', '', $truncated); // odreži do zadnje cele besede
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

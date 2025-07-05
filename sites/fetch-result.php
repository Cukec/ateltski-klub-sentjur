<?php
require_once 'config.php';

$discipline = isset($_GET['discipline']) ? (int)$_GET['discipline'] : 0;
$selection = isset($_GET['selection']) ? (int)$_GET['selection'] : 0;

if (!$discipline || !$selection) {
    echo '<tr><td colspan="4">Neveljavna izbira.</td></tr>';
    exit;
}

$query = "SELECT 
            COALESCE(a.result_time, a.result_technical) AS result,
            a.date, a.location,
            p.name, p.surname
          FROM accomplishments a
          JOIN people p ON a.id_people = p.id
          WHERE a.id_discipline = ? AND a.id_selection = ?
          ORDER BY a.date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $discipline, $selection);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<tr><td colspan="4">Ni rezultatov za izbrano kombinacijo.</td></tr>';
    exit;
}

while ($row = $result->fetch_assoc()) {
    $rezultat = htmlspecialchars($row['result']);
    $ime = htmlspecialchars($row['name']);
    $priimek = htmlspecialchars($row['surname']);
    $leto = date('Y', strtotime($row['date']));
    $kraj = htmlspecialchars($row['location']);

    echo "<tr>
            <td>{$rezultat}</td>
            <td>{$ime} {$priimek}</td>
            <td>{$leto}</td>
            <td>{$kraj}</td>
          </tr>";
}
?>

<?php
require_once 'config.php';

$selectedDiscipline = $_GET['discipline'] ?? '';
$selectedSelection = $_GET['selection'] ?? '';

// Pridobi selekcije
$selectionsQuery = "SELECT id, title FROM selection ORDER BY id ASC";
$selections = $conn->query($selectionsQuery);

// Pridobi discipline po vrstnem redu
$disciplineQuery = "SELECT id, title FROM discipline ORDER BY num_out ASC";
$disciplineResult = $conn->query($disciplineQuery);
$disciplines = [];
while ($d = $disciplineResult->fetch_assoc()) {
    $disciplines[] = $d;
}

while ($selection = $selections->fetch_assoc()) {
    $selectionId = $selection['id'];
    $selectionTitle = htmlspecialchars($selection['title']);

    // Če je filtrirano in selekcija ne ustreza, preskoči
    if ($selectedSelection && $selectedSelection != $selectionId) continue;

    echo "<h1>$selectionTitle</h1>";

    foreach ($disciplines as $discipline) {
        $disciplineId = $discipline['id'];
        $disciplineTitle = htmlspecialchars($discipline['title']);

        // Če je filtrirano in disciplina ne ustreza, preskoči
        if ($selectedDiscipline && $selectedDiscipline != $disciplineId) continue;

        $query = "SELECT a.result_time, a.result_technical, a.date, a.location, p.name, p.surname
                  FROM accomplishments a
                  JOIN people p ON a.id_people = p.id
                  WHERE a.is_tablica = 1
                    AND a.id_selection = ?
                    AND a.id_discipline = ?
                  ORDER BY a.date DESC";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $selectionId, $disciplineId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h2>$disciplineTitle</h2>";
            echo '<table class="result-table">';
            echo '<thead>
                    <tr>
                      <th>Rezultat</th>
                      <th>Ime in priimek</th>
                      <th>Leto</th>
                      <th>Kraj</th>
                    </tr>
                  </thead><tbody>';

            while ($row = $result->fetch_assoc()) {
                $rezultat = htmlspecialchars($row['result_time'] ?: $row['result_technical']);
                $ime = htmlspecialchars($row['name'] . ' ' . $row['surname']);
                $leto = date("Y", strtotime($row['date']));
                $kraj = htmlspecialchars($row['location']);

                echo "<tr>
                        <td>$rezultat</td>
                        <td>$ime</td>
                        <td>$leto</td>
                        <td>$kraj</td>
                      </tr>";
            }

            echo '</tbody></table><br>';
        }
    }
}
?>

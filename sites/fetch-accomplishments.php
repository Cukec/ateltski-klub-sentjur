<?php
include "config.php";

// Get the discipline and selection filter values from the query parameters
$disciplineId = isset($_GET['discipline']) ? (int)$_GET['discipline'] : null;
$selectionId = isset($_GET['selection']) ? (int)$_GET['selection'] : null;

// Start building the query with the necessary conditions
$whereClauses = [];

if ($disciplineId) {
    $whereClauses[] = "di.id = $disciplineId";
}

if ($selectionId) {
    $whereClauses[] = "se.id = $selectionId";
}

$whereCondition = implode(' AND ', $whereClauses);

// Query to get all the accomplishments based on the filters
$query = "SELECT p.name, p.surname, p.gender, p.id as p_id, ac.*, di.title as di_title, di.id as d_id, se.id as s_id, se.title as se_title 
          FROM accomplishments ac 
          JOIN people_accomplishments pa ON ac.id = pa.id_accomplishment 
          JOIN people p ON pa.id_people = p.id 
          JOIN athlete a ON p.id = a.id_people 
          JOIN athlete_selection ase ON a.id = ase.id_athlete 
          JOIN selection se ON ase.id_selection = se.id 
          JOIN athlete_discipline ad ON a.id = ad.id_athlete 
          JOIN discipline di ON ad.id_discipline = di.id
          WHERE 1 " . ($whereCondition ? "AND $whereCondition" : '') . "
          AND is_tablica = 1
          ORDER BY ac.date DESC";

// Debugging: Log the query to check if it's correct
error_log("SQL Query: " . $query);

$result = $conn->query($query);

// Check if there are results
if ($result->num_rows > 0) {
    $accomplishments = [];
    while ($row = $result->fetch_assoc()) {
        $accomplishments[] = [
            'name' => htmlspecialchars($row['name']),
            'surname' => htmlspecialchars($row['surname']),
            'gender' => htmlspecialchars($row['gender']),
            'accomplishment_id' => $row['id'],  // Assuming 'id' is the unique identifier for accomplishments
            'result' => htmlspecialchars($row['result']),
            'date' => $row['date'] ? (new DateTime($row['date']))->format('d-m-Y') : null,
            'location' => htmlspecialchars($row['location']),
            'description' => htmlspecialchars($row['description']),  // Added description here
            'discipline' => htmlspecialchars($row['di_title']),
            'selection' => htmlspecialchars($row['se_title']),
            'discipline_id' => $row['d_id'],
            'selection_id' => $row['s_id'],
            'person_id' => $row['p_id'],
        ];
    }

    // Return the results as JSON
    echo json_encode([
        'accomplishments' => $accomplishments
    ]);
} else {
    // No results found
    echo json_encode([
        'accomplishments' => []
    ]);
}
?>

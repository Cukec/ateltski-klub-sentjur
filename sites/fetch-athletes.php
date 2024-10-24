<?php
include "config.php";

// Define how many results per page
$resultsPerPage = 10;

// Get the requested page number and type (active/ex-athlete) from the AJAX request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : 'active';  // Default to 'active'
if ($page < 1) $page = 1;

// Determine the starting limit for the results
$offset = ($page - 1) * $resultsPerPage;

// Set the active condition based on type
$activeCondition = ($type === 'active') ? "a.active = 1" : "a.active = 0";

// Query to get the profiles for the current page
$query = "SELECT p.id, p.name, p.surname, p.gender, p.date_of_birth, a.id AS athlete_id 
          FROM people p 
          JOIN athlete a ON p.id = a.id_people 
          WHERE $activeCondition
          ORDER BY p.surname ASC 
          LIMIT $resultsPerPage OFFSET $offset";
$result = $conn->query($query);

$athletes = [];
while ($profile = $result->fetch_assoc()) {
    // Fetch disciplines for the current athlete
    $athleteId = $profile['athlete_id'];
    $disciplineQuery = "SELECT d.title 
                        FROM athlete_discipline ad 
                        JOIN discipline d ON ad.id_discipline = d.id 
                        WHERE ad.id_athlete = $athleteId";
    $disciplineResult = $conn->query($disciplineQuery);
    $disciplines = [];

    while ($discipline = $disciplineResult->fetch_assoc()) {
        $disciplines[] = htmlspecialchars($discipline['title']);
    }

    // Add athlete to the response array
    $athletes[] = [
        'id' => $profile['athlete_id'],
        'name' => htmlspecialchars($profile['name']),
        'surname' => htmlspecialchars($profile['surname']),
        'gender' => htmlspecialchars($profile['gender']),
        'dob' => (new DateTime($profile['date_of_birth']))->format('d-m-Y'),
        'disciplines' => implode(', ', $disciplines) ?: '/'
    ];
}

// Get the total number of profiles
$totalQuery = "SELECT COUNT(*) AS total FROM people p JOIN athlete a ON p.id = a.id_people WHERE $activeCondition";
$totalResult = $conn->query($totalQuery);
$totalRows = $totalResult->fetch_assoc()['total'];

// Return data as JSON
echo json_encode([
    'athletes' => $athletes,
    'totalPages' => ceil($totalRows / $resultsPerPage),
]);

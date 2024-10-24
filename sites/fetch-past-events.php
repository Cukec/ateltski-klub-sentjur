<?php

include "config.php";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$resultsPerPage = 5;
$offset = ($page - 1) * $resultsPerPage;

// Get selected year and month from the request
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$selectedMonth = isset($_GET['month']) && $_GET['month'] != 'all' ? $_GET['month'] : null;

// Query to count total past events for the selected year and month
if ($selectedMonth) {
    $totalQuery = "SELECT COUNT(*) AS total FROM events WHERE YEAR(date_start) = $selectedYear AND MONTH(date_start) = $selectedMonth AND date_start < CURDATE()";
} else {
    $totalQuery = "SELECT COUNT(*) AS total FROM events WHERE YEAR(date_start) = $selectedYear AND date_start < CURDATE()";
}

$totalResult = $conn->query($totalQuery);
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $resultsPerPage);

// Query to fetch past events for the selected year and month
if ($selectedMonth) {
    $query = "SELECT * FROM events WHERE YEAR(date_start) = $selectedYear AND MONTH(date_start) = $selectedMonth AND date_start < CURDATE() ORDER BY date_start DESC LIMIT $resultsPerPage OFFSET $offset";
} else {
    $query = "SELECT * FROM events WHERE YEAR(date_start) = $selectedYear AND date_start < CURDATE() ORDER BY date_start DESC LIMIT $resultsPerPage OFFSET $offset";
}

$result = $conn->query($query);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $title = preg_replace('/^\d{4};/', '', $row['title']);
        $title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
        $contentPreview = substr(strip_tags($row['content']), 0, 50) . '...';
        
        $events[] = [
            'id' => $row['id'],
            'title' => $title,
            'date_start' => $row['date_start'],
            'contentPreview' => $contentPreview
        ];
    }
}

// Return events and pagination info as JSON
echo json_encode([
    'events' => $events,
    'totalPages' => $totalPages
]);

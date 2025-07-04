<?php
require 'config.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

// Skupno število novic
$totalQuery = "SELECT COUNT(*) AS total FROM news WHERE shown = 1";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

// Poizvedba za novice
$query = "SELECT id, title, content FROM news WHERE shown = 1 ORDER BY post_time DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$news = [];

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $title = htmlspecialchars($row['title']);
    $content = strip_tags($row['content']);
    $charLimit = 100;

    $truncated = strlen($content) > $charLimit
        ? preg_replace('/\s+\S*$/', '', substr($content, 0, $charLimit)) . '...'
        : $content;

    $news[] = [
        'id' => $id,
        'title' => $title,
        'content' => $truncated
    ];
}

// Vrnemo JSON z novicami in številom strani
header('Content-Type: application/json');
echo json_encode([
    'news' => $news,
    'totalPages' => $totalPages
]);

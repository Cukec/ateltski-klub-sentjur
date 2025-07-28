<?php
require 'config.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

// Skupno število novic
$totalQuery = "SELECT COUNT(*) AS total FROM news WHERE shown = 1 ORDER BY post_time DESC";
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

$i = 0;
$news = [];

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $title = htmlspecialchars($row['title']);

    // Step 1: Decode HTML entities
    $rawContent = html_entity_decode($row['content'], ENT_QUOTES, 'UTF-8');

    // Step 2: Remove <img> tags
    $contentWithoutImg = preg_replace('#<img\b[^>]*?>#i', '', $rawContent);

    // Step 3: Convert to plain text
    $plainText = strip_tags($contentWithoutImg);

    // Step 4: Truncate
    $charLimit = 100;

    if (mb_strlen($plainText) > $charLimit) {
        $truncated = mb_substr($plainText, 0, $charLimit);
        $truncated = preg_replace('/\s+\S*$/u', '', $truncated); // Cut off at last full word
        $truncated .= '...';
    } else {
        $truncated = $plainText;
    }

    $news[] = [
        'id' => $id,
        'title' => $title,
        'content' => $truncated
    ];

    $i++;
}


// Vrnemo JSON z novicami in številom strani
header('Content-Type: application/json');
echo json_encode([
    'news' => $news,
    'totalPages' => $totalPages
]);

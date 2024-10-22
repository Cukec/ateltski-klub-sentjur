<?php
include "config.php"; // Ensure the database connection is included

// Define how many results per page
$resultsPerPage = 10;

// Find out the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Determine the starting limit for the results
$offset = ($page - 1) * $resultsPerPage;

// Query to get the events for the current page
$query = "SELECT title, content, date_start FROM events ORDER BY date_start ASC LIMIT $resultsPerPage OFFSET $offset;";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Remove the year and semicolon from the title
        $title = preg_replace('/^\d{4};/', '', $row['title']);
        
        // Strip HTML tags and display the first 50 characters of the content
        $cleanContent = strip_tags($row['content']);
        $contentPreview = substr($cleanContent, 0, 50) . '...';
        ?>
        <div class="novica">
            <!-- Display title and date next to each other -->
            <div style="display: flex; flex-direction: horizontal;">
                <h2> <?= htmlspecialchars($title); ?> </h2>
                <h2 style="color: #dedede; margin-left: 1vw;"> <?=  htmlspecialchars($row['date_start']); ?> </h2>
            </div>
            <p> <?= htmlspecialchars($contentPreview); ?> </p>
        </div>
        <?php
    }
} else {
    echo "No news available.";
}
?>

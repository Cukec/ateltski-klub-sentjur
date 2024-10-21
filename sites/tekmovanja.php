<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dogodki</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <link rel="stylesheet" href="styles/tekmovanja.css"/>
</head>
<body>

    <?php include "navigation.php"; include "config.php"; ?>
    
    <div class="dogodki-info">
        <h1>Koledar dogodkov</h1>
        <div id="calendar"></div>
    </div>

    <div class="naslov-dogodki" id="past-events-section"> <!-- Added ID here -->
        <h1>Pretekli dogodki</h1>
    </div>

    <section class="content">
        <div class="past-events" id="events-container">
            <div class="novice">
                <?php 
                // Define how many results per page
                $resultsPerPage = 10;

                // Find out the current page number
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if ($page < 1) $page = 1;

                // Determine the starting limit for the results
                $offset = ($page - 1) * $resultsPerPage;

                // Query to count total events that happened before today
                $totalQuery = "SELECT COUNT(*) AS total FROM events WHERE date_start < CURDATE()";
                $totalResult = $conn->query($totalQuery);
                $totalRows = $totalResult->fetch_assoc()['total'];

                // Calculate the total number of pages
                $totalPages = ceil($totalRows / $resultsPerPage);

                // Query to get the events for the current page, most recent first
                $query = "SELECT * FROM events WHERE date_start < CURDATE() ORDER BY date_start DESC LIMIT $resultsPerPage OFFSET $offset;";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Remove the year and semicolon from the title
                        $title = preg_replace('/^\d{4};/', '', $row['title']);
                        
                        // Ensure correct character encoding is handled
                        $title = html_entity_decode($title, ENT_QUOTES, 'UTF-8'); // Decode any HTML entities
                        $cleanContent = strip_tags($row['content']);
                        $contentPreview = substr($cleanContent, 0, 50) . '...';
                        
                        // Assume you have an 'id' field in your 'events' table to uniquely identify each event
                        $eventId = $row['id'];
                        ?>
                        <div class="novica">
                            <!-- Display title and date next to each other -->
                            <div style="display: flex; flex-direction: horizontal;">
                                <!-- Make title clickable and redirect to info-dogodek.php with event id as a query parameter -->
                                <h2>
                                    <a href="info-dogodek.php?id=<?= $eventId; ?>" style="text-decoration: none; color: inherit;">
                                        <?= $title; ?>
                                    </a>
                                </h2>
                                <h2 style="color: #dedede; margin-left: 1vw;"> <?= htmlspecialchars($row['date_start']); ?> </h2>
                            </div>
                            <p> <?= htmlspecialchars($contentPreview); ?> </p>
                        </div>
                        <?php
                    }
                } else {
                    echo "No news available.";
                }
                
                
                ?>
            </div>
        </div>

        <!-- Minimalist Pagination Links -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>#past-events-section" class="arrow">&lt;</a> <!-- Left Arrow -->
            <?php endif; ?>
            
            <span class="page-number"><?= $page ?></span> <!-- Current Page Number -->

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>#past-events-section" class="arrow">&gt;</a> <!-- Right Arrow -->
            <?php endif; ?>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#calendar", {
                inline: true,
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    console.log("Selected date:", dateStr);
                },
                onReady: function(selectedDates, dateStr, instance) {
                    console.log("Calendar is ready");
                }
            });
        });
    </script>
    <?= include"footer.php"; ?>
</body>
</html>

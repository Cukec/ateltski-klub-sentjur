<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/info-novica-dogodek.css">
</head>
<body>
    <?php include "navigation.php";  include "config.php"; ?>

    <main>

    <?php
    // info-dogodek.php

    if (isset($_GET['id'])) {
        $eventId = (int)$_GET['id']; // Sanitize the input

        // Query to get event details
        $query = "SELECT * FROM events WHERE id = $eventId";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $event = $result->fetch_assoc();
            
            // Remove HTML tags and decode any HTML entities
            $title = html_entity_decode(strip_tags($event['title']), ENT_QUOTES, 'UTF-8');
            $content = $event['content'];
            $dateStart = htmlspecialchars($event['date_start']);
            
            // Remove the leading year and semicolon (e.g., "2018;")
            $title = preg_replace('/^\d{4};\s*/', '', $title);
            ?>
            <!-- Output inside a div with a class -->
            <div class="event-details">
                <div style="display: flex; flex-direction: horizontal;">
                    <h1><?= htmlspecialchars($title); ?></h1> <!-- Event title -->
                    <h1 style="color: #dedede; margin-left: 1vw;"><?= $dateStart; ?></h1> <!-- Event date -->
                </div>
                <hr>
                <?= $content ?>

            </div>
            <?php
        } else {
            echo "<div class='event-details'>Event not found.</div>";
        }
    } else {
        echo "<div class='event-details'>Invalid event.</div>";
    }
    ?>

    <div class="go-back">
        <a href="dogodki.php">nazaj ↶</a>
    </div>
    </main>
    <?php include "footer.php"; ?>
</body>
</html>
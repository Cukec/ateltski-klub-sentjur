<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tekmovanja</title>

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

    <section class="content">
        <div class="past-events">
            <h2>Pretekla tekmovanja</h2>
            <div class="novice">
                <?php 
                $query = "SELECT title, content, date_start FROM events ORDER BY date_start ASC;";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="novica">
                            <h2> <?= htmlspecialchars($row['title']); ?> </h2>
                            <p> <?= htmlspecialchars($row['content']); ?> </p>
                            <p style="color: #f3f3f3; float: right;"> <?= htmlspecialchars($row['date_start']); ?> </p>
                        </div>
                        <?php
                    }
                } else {
                    echo "No news available.";
                }
                ?>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#calendar", {
                inline: true, // Show the calendar inline
                dateFormat: "Y-m-d", // Date format if needed
                onChange: function(selectedDates, dateStr, instance) {
                    console.log("Selected date:", dateStr);
                },
                onReady: function(selectedDates, dateStr, instance) {
                    console.log("Calendar is ready");
                }
            });
        });
    </script>

</body>
</html>

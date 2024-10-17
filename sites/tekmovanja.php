<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tekmovanja</title>

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css' rel='stylesheet' />

    <link rel="stylesheet" href="styles/tekmovanja.css"/>

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>
</head>
<body>

    <?php include "navigation.php"; include "config.php"; ?>

    <section class="content">
        <!-- Calendar Container -->
        <div id="calendar" style="max-width: 900px; margin: 40px auto;"></div>

        <!-- Past Events Section -->
        <div class="past-events">
            <h2>Pretekla tekmovanja</h2>
            <!-- Novice (News) //spremeni tako da bo class = past-dogodki (ne pozabit CSS) -->
            <div class="novice">
                <?php 

                // Define the SQL SELECT query
                $query = "SELECT title, content, date_start FROM events ORDER BY date_start ASC;";

                // Execute the query
                $result = $conn->query($query);

                // Check if the query returns any results
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="novica">
                            <h2> <?= $row['title']; ?> </h2>
                            <p> <?= $row['content']; ?> </p>
                            <p style ="color: #f3f3f3; float: right;"> <?php $row['date_start'] ?> </p>
                        </div>
                        <?php
                    }
                } else {
                    echo "No news available.";
                }

                // Close the database connection
                //$conn->close();
                ?>
            </div>
        </div>
    </section>
   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: false, // Disable event dragging and resizing
                selectable: false, // Disable range selection

                // Fetch events from the server (adjust the path to your actual PHP file)
                events: 'fetch-events.php',

                // Do not display time with events
                displayEventTime: false,

                // Optional: Ensure no time is formatted/displayed
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                }
            });

            // Render the calendar
            calendar.render();
        });
    </script>


</body>
</html>

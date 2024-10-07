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

    <?php include "navigation.php"; ?>

    <section class="content">
        <!-- Calendar Container -->
        <div id="calendar" style="max-width: 900px; margin: 40px auto;"></div>

        <!-- Past Events Section -->
        <div class="past-events">
            <h2>Pretekle novice</h2>
            <!-- Novice (News) //spremeni tako da bo class = past-dogodki (ne pozabit CSS) -->
            <div class="novice">
                <div class="novica">
                    <h2>Novica 1</h2>
                    <p>Opis novice 1: Tukaj je opis prve novice.</p>
                </div>
                <div class="novica">
                    <h2>Novica 2</h2>
                    <p>Opis novice 2: Tukaj je opis druge novice.</p>
                </div>
                <div class="novica">
                    <h2>Novica 3</h2>
                    <p>Opis novice 3: Tukaj je opis tretje novice.</p>
                </div>
            </div>
        </div>
    </section>
   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true, // Allows users to drag and drop events
                selectable: true, // Allows users to select date ranges

                // Add a click handler to add events
                select: function(info) {
                    var title = prompt('Enter Event Title:');
                    if (title) {
                        calendar.addEvent({
                            title: title,
                            start: info.startStr,
                            end: info.endStr,
                            allDay: info.allDay
                        });
                    }
                    calendar.unselect(); // Clear selection
                },

                // Sample preloaded events (optional)
                events: [
                    {
                        title: 'Sample Event 1',
                        start: '2024-10-05'
                    },
                    {
                        title: 'Sample Event 2',
                        start: '2024-10-12'
                    }
                ]
            });

            calendar.render();
        });
    </script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="styles/domov.css">

    <title>Domov</title>
</head>
<body>
    
    <?php include "navigation.php";  include "config.php"; ?>
    <div class="main-content">
        <div class="novice-container">
            <!--<div class="naslov-novice">
                <button id="openModalBtn" class="add-news-btn">Dodaj Novico</button>
                <h1>AKTULANO</h1>
            </div> -->
                <!-- Novice (News) -->
                <div class="novice">
                    <?php 
                    // Define the SQL SELECT query
                    $query = "SELECT title, content FROM news WHERE shown = 1 ORDER BY post_time DESC LIMIT 6;";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="novica-placeholder">
                                <div class="novica-image">
                                    <img src="../assets/news_placeholder.jpg" alt="Placeholder Image">
                                </div>
                                <div class="novica-title">
                                    <a href="info-novica.php"><h2><?= $row['title']; ?></h2></a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No news available.";
                    }
                    ?>
                </div>


                <!-- Modal for Adding News -->
                <div id="addNewsModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Dodaj Novico</h2>
                        <form id="newsForm" action="submit-news.php" method="POST">
                            <label for="title">Naslov:</label>
                            <input type="text" id="title" name="title" required><br>

                            <label for="content">Vsebina:</label>
                            <textarea id="content" name="content" rows="4" required></textarea><br>

                            <label for="shown">PrikaÅ¾i novico:</label>
                            <select id="shown" name="shown">
                                <option value="1">Da</option>
                                <option value="0">Ne</option>
                            </select><br>

                            <label for="post_time">Datum objave:</label>
                            <input type="date" id="post_time" name="post_time" required><br>

                            <button type="submit">Dodaj Novico</button>
                        </form>
                    </div>
                </div>
        </div>
        <div class="desni-container">
            <div class="atletska-sola">
                <a href="treningi.php"><img src="../assets/logo-atletska-sola.png" alt="logo-atletska-sola"></a>
            </div>
            <div id="calendar"></div>
        </div>
    </div>
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

        function resizeTextToFit(element) {
            let fontSize = parseInt(window.getComputedStyle(element).fontSize);
            while (element.scrollWidth > element.clientWidth && fontSize > 10) { // Stops at a minimum font size of 10px
                fontSize--;
                element.style.fontSize = `${fontSize}px`;
            }
        }

        const titleElement = document.querySelector(".novica-title a");
        resizeTextToFit(titleElement);

    </script>
    <?php include ('footer.php') ?>
        <script src="modal-news.js"></script> <!-- Include the modal JavaScript -->        
        <script src="modal-events.js"></script>
</body>
</html>

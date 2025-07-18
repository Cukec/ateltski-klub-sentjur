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

                // Execute the query
                $result = $conn->query($query);

                // Check if the query returns any results
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        if (isset($row['id_image']) && $row['id_image'] != NULL) {
                            ?>
                                <div class="novica-img">
                                    <div class="novica-left">
                                        <img src="../assets/16-9-aspect-ratio-test.jpg" alt="placeholder-image">
                                    </div>
                                    <div class="novica-right">
                                        <a href="info-novica.php"><h2> <?= $row['title']; ?> </h2></a>
                                        <p> <?= $row['content']; ?> </p>
                                    </div>
                                </div>
                            <?php
                        }
                        else {
                            ?>
                                <div class="novica-img-null">
                                    <div class="novica-title">
                                        <a href="info-novica.php"><h2> <?= $row['title']; ?> </h2></a>
                                    </div>
                                    <div class="novica-text">
                                        <p> <?= $row['content']; ?> </p>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                } else {
                    echo "No news available.";
                }

                // Close the database connection
                //$conn->close();
                ?>


                    
                <!-- More news here -->
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
    </script>
    <?php include ('footer.php') ?>
        <script src="modal-news.js"></script> <!-- Include the modal JavaScript -->        
        <script src="modal-events.js"></script>
</body>
</html>

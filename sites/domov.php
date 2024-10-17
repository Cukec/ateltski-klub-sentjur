<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/domov.css">

    <title>Domov</title>
</head>
<body>
    
    <?php include "navigation.php";  include "config.php"; ?>

    <!-- <div class="filler-img">
        <img src="../assets/homepage-background.jpg" alt="Filler Image" class="fullscreen-img">
    </div> -->
    <!-- Main content container -->
    <div class="main-content">
        <div class="container">
            <!-- Rotacija slik (Image Rotation) -->
            <!-- <div class="img-rotation">
                <img src="blank.jpg" alt="Blank Image" class="rotation-img">
            </div> -->

            <div class="dogodki-container">
                <div class="naslov-dogodek" style="display: flex; flex-direction: horizontal;">
                    <h1>Prihajajoči dogodki:</h1>
                    <button id="openEventModalBtn" class="add-news-btn">Dodaj Dogodek</button>
                </div>
                <!-- Dogodki (Events) -->
                <div class="dogodki">
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
        </div>

        <!-- Modal for Adding Events -->
        <div id="addEventModal" class="modal">
            <div class="modal-content">
                <span class="close-event">&times;</span>
                <h2>Dodaj Dogodek</h2>
                <form id="eventForm" action="submit-event.php" method="POST">
                    <label for="eventTitle">Naslov dogodka:</label>
                    <input type="text" id="eventTitle" name="title" required><br>

                    <label for="eventContent">Vsebina dogodka:</label>
                    <textarea id="eventContent" name="content" rows="4" required></textarea><br>

                    <label for="type">Tip dogodka:</label>
                    <input type="number" id="type" name="type" min="1" required><br>

                    <label for="datetime_start">Začetek dogodka:</label>
                    <input type="date" id="datetime_start" name="date_start" required><br>

                    <label for="datetime_end">Konec dogodka:</label>
                    <input type="date" id="datetime_end" name="date_end"><br>

                    <button type="submit">Dodaj Dogodek</button>
                </form>
            </div>
        </div>

        <script src="modal-events.js"></script>

        

        <div class="naslov-novice" style="display: flex; flex-direction: horizontal;" >
            <button id="openModalBtn" class="add-news-btn">Dodaj Novico</button>
            <h1>Novice</h1>
        </div>

        <!-- Novice (News) -->
        <div class="novice">

        <?php 

            // Define the SQL SELECT query
            $query = "SELECT title, content FROM news WHERE shown = 1;";

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
                    </div>
                    <?php
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

                    <label for="shown">Prikaži novico:</label>
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

        <script src="modal-news.js"></script> <!-- Include the modal JavaScript -->

    </div>
    <?php include ('footer.php') ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/domov.css">

    <title>Domov</title>
</head>
<body>
    
    <?php include "navigation.php"; include "config.php"; ?>

    <?php 
    
        // Define the SQL SELECT query
        $sql = "SELECT id, username, mail FROM admin";

        // Execute the query and get the result
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output data for each row
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"]. " - Username: " . $row["username"]. " - Email: " . $row["mail"]. "<br>";
            }
        } else {
            echo "0 results";
        }

        // Close the database connection
        $conn->close();

    ?>

    <!-- Main content container -->
    <div class="main-content">
        <div class="container">
            <!-- Rotacija slik (Image Rotation) -->
            <div class="img-rotation">
                <img src="blank.jpg" alt="Blank Image" class="rotation-img">
            </div>

            <div class="dogodki-container">
                <div class="naslov" style="display: flex; flex-direction: horizontal;">
                    <h1>Prihajajoči dogodki:</h1>
                    <button id="openEventModalBtn" class="add-news-btn">Dodaj Dogodek</button>
                </div>
                <!-- Dogodki (Events) -->
                <div class="dogodki">
                    <div class="dogodek">
                        <h2>Dogodek 1</h2>
                        <p>Opis dogodka 1: Tukaj je opis prvega dogodka.</p>
                    </div>
                    <div class="dogodek">
                        <h2>Dogodek 2</h2>
                        <p>Opis dogodka 2: Tukaj je opis drugega dogodka.</p>
                    </div>
                    <div class="dogodek">
                        <h2>Dogodek 3</h2>
                        <p>Opis dogodka 3: Tukaj je opis tretjega dogodka.</p>
                    </div>
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
                    <input type="datetime-local" id="datetime_start" name="datetime_start" required><br>

                    <label for="datetime_end">Konec dogodka:</label>
                    <input type="datetime-local" id="datetime_end" name="datetime_end"><br>

                    <button type="submit">Dodaj Dogodek</button>
                </form>
            </div>
        </div>

        <script src="modal-events.js"></script>


        <div class="naslov" style="display: flex; flex-direction: horizontal;" >
            <h1>Novice:</h1>
            <button id="openModalBtn" class="add-news-btn">Dodaj Novico</button> <!-- Add button for adding news -->
        </div>

        <!-- Novice (News) -->
        <div class="novice">
            <div class="novica">
                <h2>Novica 1</h2>
                <p>Opis novice 1: Tukaj je opis prve novice.</p>
            </div>
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
                    <input type="datetime-local" id="post_time" name="post_time" required><br>

                    <button type="submit">Dodaj Novico</button>
                </form>
            </div>
        </div>

        <script src="modal-news.js"></script> <!-- Include the modal JavaScript -->

    </div>

</body>
</html>

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
                <!-- Novice (News) -->
                <div class="novice">
                    <?php 
                    // Define the SQL SELECT query
                    $query = "SELECT id, title, content, id_image FROM news WHERE shown = 1 ORDER BY post_time DESC LIMIT 6;";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="novica-placeholder">
                                <div class="novica-image">
                                    <img src="../assets/news-placeholder.jpg" alt="Placeholder Image">
                                </div>
                                <div class="novica-title">
                                    <a href="info-novica.php?id=<?= $row['id']; ?>"style="text-decoration: none; color: inherit;">
                                        <h2><?= htmlspecialchars($row['title']); ?></h2>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No news available.";
                    }
                    ?>
                </div>
        </div>
        <div class="desni-container">
            <div class="atletska-sola">
                <a href="treningi.php"><img src="../assets/logo-atletska-sola.png" alt="logo-atletska-sola"></a>
            </div>
            <div id="calendar"></div>
        </div>
    </div>
    <?php include ('footer.php') ?>
</body>
</html>

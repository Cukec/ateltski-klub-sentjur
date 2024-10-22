<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/atleti.css">
    <title>Aktivni atleti</title>
</head>
<body>

    <?php include "navigation.php"; include "config.php"; ?>

    <?php 
    // Database connection
    // Assuming you have a $conn variable that connects to your database

    // Define how many results per page
    $resultsPerPage = 12;

    // Find out the current page number
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;

    // Determine the starting limit for the results
    $offset = ($page - 1) * $resultsPerPage;

    // Query to count total profiles
    $totalQuery = "SELECT COUNT(*) AS total FROM people p JOIN athlete a ON p.id = a.id_people WHERE a.active = 1";
    $totalResult = $conn->query($totalQuery);
    $totalRows = $totalResult->fetch_assoc()['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalRows / $resultsPerPage);

    // Query to get the profiles for the current page
    $query = "SELECT p.id, p.name, p.surname, p.gender, p.date_of_birth, a.id AS athlete_id 
              FROM people p 
              JOIN athlete a ON p.id = a.id_people 
              WHERE a.active = 1
              ORDER BY p.surname ASC 
              LIMIT $resultsPerPage OFFSET $offset";
    $result = $conn->query($query);
    ?>

    <div class="custom-shape">
        <div class="left-text">
            <h2>aktivni atleti</h2>
        </div>
        <div class="vertical-line"></div>
        <div class="right-text">
            <p>Spodaj so navedeni aktivni atleti AK Šentjur</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const shape = document.querySelector('.custom-shape');
            shape.classList.add('slide-in');
        });
    </script>

    <div class="content">
    <section class="profile-container">

        <?php
        if ($result->num_rows > 0) {
            echo '<table class="athletes-table">';
            echo '
                <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Priimek</th>
                        <th>Datum rojstva</th>
                        <th>Spol</th>
                        <th>Discipline</th>
                    </tr>
                </thead>
                <tbody>
            ';

            while ($profile = $result->fetch_assoc()) {
                // Fetch disciplines for the current athlete
                $athleteId = $profile['athlete_id'];
                $disciplineQuery = "SELECT d.title 
                                    FROM athlete_discipline ad 
                                    JOIN discipline d ON ad.id_discipline = d.id 
                                    WHERE ad.id_athlete = $athleteId";
                $disciplineResult = $conn->query($disciplineQuery);
                $disciplines = [];

                if ($disciplineResult->num_rows > 0) {
                    while ($discipline = $disciplineResult->fetch_assoc()) {
                        $disciplines[] = htmlspecialchars($discipline['title']);
                    }
                }

                // Join disciplines into a single string
                $disciplinesList = implode(', ', $disciplines);
                $gender;

                if (isset($profile['gender']) && strtolower($profile['gender']) == 'm') {
                    $gender = 'Moški';
                } else {
                    $gender = 'Ženski';
                }
                
                $dob = new DateTime($profile['date_of_birth']);

                // Output table row
                echo '
                <tr onClick="window.location.href=\'info-atlet.php?id=' . $profile['athlete_id'] . '\'">
                    <td>' . htmlspecialchars($profile['name']) . '</td>
                    <td>' . htmlspecialchars($profile['surname']) . '</td>
                    <td>' . $dob->format('d-m-Y') . '</td>
                    <td>' . htmlspecialchars($gender) . '</td>
                    <td>' . ($disciplinesList ?: 'No disciplines listed') . '</td>
                </tr>';

            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo "No profiles available.";
        }
        ?>

    </section>

    <!-- Minimalist Pagination Links -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="arrow">&lt;</a> <!-- Left Arrow -->
        <?php endif; ?>
        
        <span class="page-number"><?= $page ?></span> <!-- Current Page Number -->

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" class="arrow">&gt;</a> <!-- Right Arrow -->
        <?php endif; ?>
    </div>
    </div>
    
    <script>
        window.onload = function() {
            document.querySelector('table').style.opacity = 1;
        };
    </script>

    <?php include "footer.php"; ?>
</body>
</html>

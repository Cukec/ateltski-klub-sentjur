<?php 
include "config.php"; // Database connection
include "navigation.php";

// Get the athlete ID from the URL query parameter
$athleteId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($athleteId > 0) {
    // Query to fetch the athlete's personal information
    $athleteQuery = "SELECT p.name, p.surname, p.gender, p.date_of_birth, p.description, a.id AS athlete_id, p.id AS people_id
                     FROM people p
                     JOIN athlete a ON p.id = a.id_people
                     WHERE a.id = $athleteId AND a.active = 1";
    
    $athleteResult = $conn->query($athleteQuery);

    // Check if the athlete exists
    if ($athleteResult->num_rows > 0) {
        $athlete = $athleteResult->fetch_assoc();

        // Fetch the athlete's disciplines
        $disciplineQuery = "SELECT d.title 
                            FROM athlete_discipline ad 
                            JOIN discipline d ON ad.id_discipline = d.id 
                            WHERE ad.id_athlete = $athleteId";
        $disciplineResult = $conn->query($disciplineQuery);
        $disciplines = [];

        $ppl_id = $athlete['people_id'];

        $queryAccomplishments = "SELECT * FROM accomplishments WHERE id_people = $ppl_id";
        $resultAcc = $conn->query($queryAccomplishments);

        // Initialize two arrays
        $clubAccArray = [];
        $tablicaArray = [];

        // Process the result
        if ($resultAcc->num_rows > 0) {

            $accom = $resultAcc->fetch_assoc();

            $id_discipline = $accom['id_discipline'];
            $id_accomplishment = $accom['id'];
            
            $queryPersonalBest = "SELECT * FROM discipline d JOIN athlete_discipline ad ON d.id = ad.id_discipline JOIN athlete a ON ad.id_athlete = a.id JOIN people p ON a.id_people = p.id JOIN people_accomplishments pa ON p.id = pa.id_people JOIN accomplishments ac ON pa.id_accomplishment = ac.id
                                WHERE d.id = $id_discipline
                                AND pa.id_accomplishment = $id_accomplishment
                                AND p.id = $ppl_id";

            while ($row = $resultAcc->fetch_assoc()) {
                // Check for is_club_acc
                if ($row['is_club_acc'] == 1) {
                    $clubAccArray[] = htmlspecialchars($row['description']); // Store titles for club accomplishments
                }
                
                // Check for is_tablica
                if ($row['is_tablica'] == 1) {
                    $tablicaArray[] = htmlspecialchars($row['result']); // Store titles for tablica accomplishments
                }
            }
        }

        if ($disciplineResult->num_rows > 0) {
            while ($discipline = $disciplineResult->fetch_assoc()) {
                $disciplines[] = htmlspecialchars($discipline['title']);
            }
        }

        // Format date of birth and gender
        $dob = new DateTime($athlete['date_of_birth']);
        $formattedDob = $dob->format('d-m-Y');
        $gender = strtolower($athlete['gender']) == 'm' ? 'Moški' : 'Ženski';
        $disciplinesList = implode(', ', $disciplines);
        $clubAccList = implode(', ', $clubAccArray);
        $tablicaList = implode(', ', $tablicaArray);
    } else {
        echo "<p>No athlete found with this ID.</p>";
    }
} else {
    echo "<p>Invalid athlete ID.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/info-atlet.css">
    <title>Atleti</title>
</head>
<body>

<main>
    <div class="athlete-wrapper">
        <div class="athlete-info">
            <?php if (isset($athlete)) : ?>
                <h2><?= htmlspecialchars($athlete['name']) . ' ' . htmlspecialchars($athlete['surname']) ?></h2>
                <p><strong>Spol:</strong> <?= htmlspecialchars($gender) ?></p>
                <p><strong>Datum rojstva:</strong> <?= htmlspecialchars($formattedDob) ?></p>
                <p><strong>Discipline:</strong> <br> <?= $disciplinesList ? htmlspecialchars($disciplinesList) : 'Disciplin ni navedenih' ?></p>
                <p><strong>Opis:</strong> <br> <?= !empty($athlete['description']) ? htmlspecialchars($athlete['description']) : 'Za osebo ni navedenega opisa' ?></p>
                <p><strong>Klubski dosežki:</strong> <br> <?= $clubAccList ? htmlspecialchars($clubAccList) : 'Dosežkov ni navedenih' ?></p>
            <?php else : ?>
                <p>Athlete information could not be retrieved.</p>
            <?php endif; ?>
        </div>
        <div class="image-container">
            <img src="https://eu.ui-avatars.com/api/?name=John+Doe&size=250" alt="Athlete Image" class="polaroid-image">
        </div>
        <div id="green"></div>
        <div id="red"></div>
    </div>
    <div class="go-back">
        <a href="tekmovanja.php">nazaj ↶</a>
    </div>
</main>


<?php include "footer.php"; ?>
</body>
</html>

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
                     WHERE a.id = $athleteId";
    
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

            // 1. Najprej napolnimo clubAccArray in tablicaArray iz $resultAcc:
            while ($row = $resultAcc->fetch_assoc()) {
                if ($row['is_club_acc'] == 1) {
                    $clubAccArray[] = htmlspecialchars($row['description']); // klub dosežki
                }
            }

            // 2. Nato naložimo osebne rekorde po disciplinah (personal bests)
            $personalBests = [];

            $queryPersonalBest = "
                SELECT 
                    d.id AS discipline_id,
                    d.title AS discipline_title,
                    CASE 
                        WHEN MIN(a.result_time) IS NOT NULL THEN CAST(MIN(a.result_time) AS CHAR)
                        ELSE CAST(MAX(a.result_technical) AS CHAR)
                    END AS result 
                FROM accomplishments a 
                JOIN discipline d ON a.id_discipline = d.id 
                WHERE a.is_tablica = 1 
                AND a.id_people = ? 
                GROUP BY d.id, d.title;
            ";

            $stmt = $conn->prepare($queryPersonalBest);
            $stmt->bind_param('i', $ppl_id);
            $stmt->execute();
            $resPB = $stmt->get_result();

            while ($row = $resPB->fetch_assoc()) {
                $disciplineId = $row['discipline_id'];
                $personalBests[$disciplineId] = [
                    'title' => $row['discipline_title'],
                    'result' => $row['result']
                ];
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
        //echo "<p>No athlete found with this ID.</p>";
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
    <?php
    if (!isset($athlete) || !is_array($athlete)) {
        ?>
        <div class="no-athlete-message" style="text-align:center; margin:10vh auto; max-width:600px; padding:30px; border:1px solid #ddd; background:#f8f8f8; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1); color:#444;">
            <h2 style="margin-bottom:10px; color:#c00;">Podatki o tem atletu niso na voljo</h2>
            <p>Oprostite, iskanega atleta ni v naši podatkovni bazi.</p>
        </div>
        <div class="go-back" style="margin-bottom: 20vh;">
            <a href="atleti.php">nazaj ↶</a>
        </div>
        <?php
        exit;  // ustavi nadaljnjo obdelavo in izpis strani
    }
    ?>

    <div class="athlete-wrapper">
        <div class="athlete-info">
            <h2><?= htmlspecialchars($athlete['name']) . ' ' . htmlspecialchars($athlete['surname']) ?></h2>

            <?php
            $imagePath = "../gallery/osebje/$ppl_id.jpg";
            $placeholderPath = "../assets/random-placeholder-ppl.jpg";
            $finalImage = file_exists($imagePath) ? $imagePath : $placeholderPath;
            ?>
            
            <div class="polaroid float-left">
                <img src="<?= htmlspecialchars($finalImage) ?>" alt="Slika osebe" class="polaroid-img" width="100" height="120">
                <p class="caption"><?= htmlspecialchars($athlete['name'] . ' ' . $athlete['surname']) ?></p>
            </div>

            <p><strong>Spol:</strong> <?= htmlspecialchars($gender) ?></p>
            <p><strong>Datum rojstva:</strong> <?= htmlspecialchars($formattedDob) ?></p>
            <p><strong>Discipline:</strong> <br> <?= $disciplinesList ? htmlspecialchars($disciplinesList) : 'Disciplin ni navedenih' ?></p>
            <p class="caption"><strong>Opis:</strong> <br> <?= !empty($athlete['description']) ? htmlspecialchars($athlete['description']) : 'Za osebo ni navedenega opisa' ?></p>
        </div>

        <div class="accom">
            <p><strong>Klubski dosežki:</strong> <br>
            <?php if (!empty($clubAccArray) && is_array($clubAccArray)): ?>
                <ul>
                    <?php foreach ($clubAccArray as $acc): ?>
                        <li><?= htmlspecialchars($acc) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                Dosežkov ni navedenih
            <?php endif; ?>
            </p>
            <p><strong>Osebni rekordi:</strong></p>
            <?php if (!empty($personalBests)): ?>
                <ul>
                    <?php foreach ($personalBests as $pb): ?>
                        <li>
                            <?= htmlspecialchars($pb['title']) ?>: <?= htmlspecialchars($pb['result']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Osebnih rekordov ni navedenih.</p>
            <?php endif; ?>
        </div>
        <div class="go-back">
            <a href="atleti.php">nazaj ↶</a>
        </div>
    </div>
</main>


<?php include "footer.php"; ?>
</body>
</html>

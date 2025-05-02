<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spreminjanje dosežka</title>
</head>
<header>
    <?php 

        include("../../config.php");
    
        #Pridobi podatke o dosežku s poslanim id
        $stmt = $conn->prepare("SELECT * FROM accomplishments WHERE id = ?");
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if( $result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo 'Napaka pri pridobivanju podatkov dosežka';
        }

        $id_people = $row['id_people'];
        echo $id_people;
        $stmt = $conn->prepare("SELECT id, CONCAT(name, ' ', surname) AS fullname FROM people WHERE id = ?");
        $stmt->bind_param("i", $id_people);
        $stmt->execute();
        $osebaResult = $stmt->get_result();

        $id_selekcija = $row['id_selection'];
        $stmt = $conn->prepare("SELECT * FROM selection WHERE id = ?");
        $stmt->bind_param("i", $id_selekcija);
        $stmt->execute();
        $selekcijaResult = $stmt->get_result();

        $id_disciplina = $row['id_discipline'];
        $stmt = $conn->prepare("SELECT * FROM discipline WHERE id = ?");
        $stmt->bind_param("i", $id_disciplina);
        $stmt->execute();
        $disciplinaResult = $stmt->get_result();
    
    ?>
</header>
<body>
    <form method="POST" action="shrani-dosezek.php">

        <input type="text" name="id" value="<?php echo $_GET['id']; ?>" hidden>    

        <h3>Prikazovanje</h3>
        <label for="tablica">Tablica</label>
        <input type="checkbox" name="tablica" id="tablica" <?php if($row['is_tablica'] == 1) echo "checked"; ?>></input><br>

        <label for="club_acc">Dosežek kluba</label>
        <input type="checkbox" name="club_acc" id="club_acc" <?php if($row['is_club_acc'] == 1) echo "checked"; ?>></input>

        <h3>Podatki dosežka</h3>
        <label for="date">Datum:</label><br>
        <input type="date" name="date" id="date" value="<?php if(isset($row['date'])) echo $row['date']; ?>"><br>
        <label for="description">Kratek opis:</label><br>
        <textarea name="description" id="description"><?php if(isset($row['description'])) echo $row['description']; ?></textarea><br>
        <label for="location">Lokacija:</label><br>
        <input type="text" name="location" id="location" value="<?php if(isset($row['location'])) echo $row['location']; ?>">

        <h3>Podatki za tablice <i style="color:lightgray;">(opcijsko)</i></h3>
        <select name="people" id="people">
            <option disabled>-- Ljudje --</option>
            <?php
                // Fetch all individuals (those with a first name)
                $stmt = $conn->prepare("SELECT id, CONCAT(surname, ' ', name) AS fullname 
                                        FROM people 
                                        WHERE name IS NOT NULL AND name != '' ORDER BY fullname");
                $stmt->execute();
                $peopleResult = $stmt->get_result();

                if ($peopleResult->num_rows > 0) {
                    while ($person = $peopleResult->fetch_assoc()) {
                        $selected = ($person['id'] == $id_people) ? "selected" : "";
                        echo "<option value='{$person['id']}' $selected>{$person['fullname']}</option>";
                    }
                } else {
                    echo "<option disabled>Ni posameznikov</option>";
                }
            ?>

            <option disabled>-- Štafete --</option>
            <?php
                // Fetch all relays (those without a first name)
                $stmt = $conn->prepare("SELECT id, surname AS fullname FROM people WHERE name IS NULL OR name = ''");
                $stmt->execute();
                $relayResult = $stmt->get_result();

                if ($relayResult->num_rows > 0) {
                    while ($relay = $relayResult->fetch_assoc()) {
                        $selected = ($relay['id'] == $id_people) ? "selected" : "";
                        echo "<option value='{$relay['id']}' $selected>{$relay['fullname']}</option>";
                    }
                } else {
                    echo "<option disabled>Ni štafet</option>";
                }
            ?>
        </select>


        <select name="selection" id="selection">
            <?php
                // Fetch all selections from the selection table
                $stmt = $conn->prepare("SELECT id, title FROM selection");
                $stmt->execute();
                $selectionResult = $stmt->get_result();

                if ($selectionResult->num_rows > 0) {
                    while ($selection = $selectionResult->fetch_assoc()) {
                        $selected = ($selection['id'] == $id_selekcija) ? "selected" : "";
                        echo "<option value='{$selection['id']}' $selected>{$selection['title']}</option>";
                    }
                } else {
                    echo "<option disabled>Ni selekcij na voljo</option>";
                }
            ?>
        </select>


        <select name="discipline" id="discipline" onchange="updateInputs()">
            <?php
                // Fetch all disciplines from the discipline table
                $stmt = $conn->prepare("SELECT * FROM discipline");
                $stmt->execute();
                $disciplineResult = $stmt->get_result();

                if ($disciplineResult->num_rows > 0) {
                    while ($discipline = $disciplineResult->fetch_assoc()) {
                        $selected = ($discipline['id'] == $id_disciplina) ? "selected" : "";
                        echo "<option value='{$discipline['id']}' $selected>{$discipline['title']}</option>";
                    }
                } else {
                    echo "<option disabled>Ni disciplin na voljo</option>";
                }
            ?>
        </select>

        <?php
    // Fetch discipline type from the database
    $stmt = $conn->prepare("SELECT type FROM discipline WHERE id = ?");
    $stmt->bind_param("i", $id_disciplina);
    $stmt->execute();
    $disciplineResult = $stmt->get_result();
    $discipline = $disciplineResult->fetch_assoc();

    $type = $discipline['type'] ?? null; // Get discipline type safely
    

    // Initialize input values
    $resultTechnical = $row['result_technical'] ?? "";
    
    $resultTime = $row['result_time'] ?? "";

    $min = $sec = $msec = $meters = $cm = "";

    // Swap the conditions to correctly match the input type
    if (!empty($resultTechnical) && $type == 2) { // Technical discipline
        list($meters, $cm) = array_pad(explode('.', $resultTechnical), 2, "");
    }

    if (!empty($resultTime) && $type == 1) { // Running discipline
        if (strpos($resultTime, ':') !== false) {
            list($min, $secAndMsec) = explode(':', $resultTime);
            list($sec, $msec) = array_pad(explode('.', $secAndMsec), 2, "");
        } else {
            list($sec, $msec) = array_pad(explode('.', $resultTime), 2, "");
        }
    }
?>

<h3>Izberite vrsto vnosa</h3>
<select name="tip" id="tip" onchange="updateVisibility()">
    <option disabled>-- Izberite tip --</option>
    <option value="2" <?= ($type == 2) ? 'selected' : '' ?>>Tehnična</option>
    <option value="1" <?= ($type == 1) ? 'selected' : '' ?>>Tek</option>
</select>

<div class="discipline-inputs" id="technical" style="display: none;">
    <input type="text" name="meters" value="<?= htmlspecialchars($meters) ?>"> <p>m</p>
    <input type="text" name="cm" value="<?= htmlspecialchars($cm) ?>"> <p>cm</p>
</div>

<div class="discipline-inputs" id="run" style="display: none;">
    <input type="text" name="minutes" value="<?= htmlspecialchars($min) ?>"> <p>min</p>
    <input type="text" name="seconds" value="<?= htmlspecialchars($sec) ?>"> <p>sec</p>
    <input type="text" name="milliseconds" value="<?= htmlspecialchars($msec) ?>"> <p>mili sec</p>
</div>

<style>
    .discipline-inputs {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .discipline-inputs input {
        width: 60px;
        text-align: center;
    }

    .discipline-inputs p {
        margin: 0;
    }
</style>

<input type="submit" name="save" id="save" value="Shrani">

<script>
    function updateVisibility() {
        let tip = document.getElementById("tip").value;

        if (tip == "2") { // Tehnična
            document.getElementById("technical").style.display = "flex";
            document.getElementById("run").style.display = "none";
        } else if (tip == "1") { // Tek
            document.getElementById("run").style.display = "flex";
            document.getElementById("technical").style.display = "none";
        }
    }

    // Run on page load to ensure correct visibility
    document.addEventListener("DOMContentLoaded", updateVisibility);
</script>

</body>
</html>
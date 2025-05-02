<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vnos novega dosežka</title>
</head>
<header>
    <?php
    
    include("../../config.php");
    
    ?>
</header>
<body>
    <form method="POST" action="dodaj-dosezek.php">
        
        <h3>Prikazovanje</h3>
        <label for="tablica">Tablica</label>
        <input type="checkbox" name="tablica" id="tablica"></input><br>

        <label for="club_acc">Dosežek kluba</label>
        <input type="checkbox" name="club_acc" id="club_acc"></input>

        <h3>Podatki dosežka</h3>
        <label for="date">Datum:</label><br>
        <input type="date" name="date" id="date"><br>
        <label for="description">Kratek opis:</label><br>
        <textarea name="description" id="description"></textarea><br>
        <label for="location">Lokacija:</label><br>
        <input type="text" name="location" id="location">

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
            <option disabled selected>-- Selekcija --</option>
            <?php
                $stmt = $conn->prepare("SELECT id, title FROM selection");
                $stmt->execute();
                $selectionResult = $stmt->get_result();
                
                while ($selection = $selectionResult->fetch_assoc()) {
                    echo "<option value='{$selection['id']}'>{$selection['title']}</option>";
                }
            ?>
        </select>

        <select name="discipline" id="discipline" onchange="updateInputs()">
            <option disabled selected>-- Disciplina --</option>
            <?php
                $stmt = $conn->prepare("SELECT id, title FROM discipline");
                $stmt->execute();
                $disciplineResult = $stmt->get_result();
                
                while ($discipline = $disciplineResult->fetch_assoc()) {
                    echo "<option value='{$discipline['id']}'>{$discipline['title']}</option>";
                }
            ?>
        </select>

        <h3>Izberite vrsto vnosa</h3>
        <select name="tip" id="tip" onchange="updateVisibility()">
            <option disabled selected>-- Izberite tip --</option>
            <option value="2">Tehnična</option>
            <option value="1">Tek</option>
        </select>

        <div class="discipline-inputs" id="technical" style="display: none;">
            <input type="text" name="meters"> <p>m</p>
            <input type="text" name="cm"> <p>cm</p>
        </div>

        <div class="discipline-inputs" id="run" style="display: none;">
            <input type="text" name="minutes"> <p>min</p>
            <input type="text" name="seconds"> <p>sec</p>
            <input type="text" name="milliseconds"> <p>mili sec</p>
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

            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("tip").value = "2"; // Set default to Tehnična
                updateVisibility();
            });
        </script>

    </form>
</body>
</html>

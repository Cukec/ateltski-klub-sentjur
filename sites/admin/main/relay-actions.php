<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<header>
    
    <!-- Place the first <script> tag in your HTML's <head>
    <script src="https://cdn.tiny.cloud/1/u336cycduxe8y6tqewtt8ylyrx1zi5rlqauhgtozzsx80cg9/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    Place the following <script> and <textarea> tags your HTML's <body>
    <script>
    tinymce.init({
    selector: 'textarea', // Target all textarea elements
    plugins: 'link image imagetools', // Include the link plugin
    toolbar: 'undo redo | bold italic underline | link', // Add link button to the toolbar
    placeholder: 'Vpišite vsebino...',
    menu: {
        edit: { title: 'Edit', items: 'undo, redo, selectall' },
        insert: { title: 'Insert', items: 'link image' }
    },
    height: 500, // Set the height in pixels
    width: '100%', // Set the width to fit the form or a specific value like '600px'
    resize: true // Allow users to manually resize the editor (optional)
    });
    </script>
    -->
    <?php 
    
    include("../../config.php"); 
    

    
    ?>

</header>
<body>
    
<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['relays']) ? (int)$_POST['relays'] : 0; // Selected news ID

    //echo $id;

    if ($action === "save") {
        
        //FORM za dodajanje osebe
        ?>
        
        <form action="add-relay.php" method="POST">
            
            <h3>Podatki štafete</h3>

            <label for="title">Naziv: </label>
            <input type="text" name="title" id="title"><br>

            <label for="gender">Spol: </label>
            <select name="gender" id="gender">
                <option value="m">Moški</option>
                <option value="z">Ženska</option>
            </select><br>
            <div>
                <label for="people">Selekcije štafete</label><br>
                <select name="people[]" id="people" multiple>
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
                                echo "<option value='{$person['id']}'>{$person['fullname']}</option>";
                            }
                        } else {
                            echo "<option disabled>Ni posameznikov</option>";
                        }
                    ?>

                </select>
            </div>
            <div>
                <label for="selection">Selekcije štafete</label><br>
                <select name="selection[]" id="selection" multiple>
                    <?php
                        $stmt = $conn->prepare("SELECT id, title FROM selection");
                        $stmt->execute();
                        $selectionResult = $stmt->get_result();
                        
                        while ($selection = $selectionResult->fetch_assoc()) {
                            echo "<option value='{$selection['id']}'>{$selection['title']}</option>";
                        }
                    ?>
                </select>
            </div>
            <div>
                <label for="discipline">Discipline štafete</label><br>
                <select name="discipline[]" id="discipline" multiple>
                    <?php
                        $stmt = $conn->prepare("SELECT id, title FROM discipline");
                        $stmt->execute();
                        $disciplineResult = $stmt->get_result();
                        
                        while ($discipline = $disciplineResult->fetch_assoc()) {
                            echo "<option value='{$discipline['id']}'>{$discipline['title']}</option>";
                        }
                    ?>
                </select>
            </div><br>

            <label for="image">Slika štefete: </label>
            <input type="file" name="image" id="image"><br>

            <button type="submit">Dodaj</button>
        </form>

        
        <?php

    } elseif ($action === "change" && $id > 0) {
        
        $stmt = $conn->prepare("SELECT * FROM people WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        
        
        $stmt->close();
        ?>
        
        <form action="save-relay.php" method="POST">
        <input type="text" value="<?php echo $id ?>" hidden> 
        <h3>Podatki osebe</h3>

        <?php
        
        $sql = "SELECT * FROM people WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        $name = $surname = $gender = $date_of_birth = $id_image = $description = "";

        if($row = $result->fetch_assoc()) {

            $id_people = $row['id'];
            $name = $row['name'];
            $surname = $row['surname'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $id_image = $row['id_image'];
            $description = $row['description'];

        }else{

            echo "Napaka pri pridobivanju podatkov osebe!<br>";

        }
        
        ?>
        <input type="text" name="id_people" id="id_people" hidden value="<?php echo $id_people; ?>">

        <label for="title">Naziv: </label>
        <input type="text" name="title" id="title" value="<?php echo $surname; ?>"><br>

        <label for="gender">Spol: </label>
        <select name="gender" id="gender">
            <option value="m" <?php if($gender == "m") echo "selected"; ?>>Moški</option>
            <option value="z" <?php if($gender == "z") echo "selected"; ?>>Ženska</option>
        </select><br>

        <?php
        
        $sql = "SELECT * FROM athlete WHERE id_people=?";

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("i", $id_people);
        $stmt->execute();
        $result = $stmt->get_result();
        
        ?>

        <?php 
        
        $sql = "SELECT * FROM athlete WHERE id_people=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_people);
        $stmt->execute();
        $result = $stmt->get_result();

        $id_athlete = $registered = $active = "";

        if ($row = $result->fetch_assoc()) {
            $id_athlete = isset($row["id"]) ? $row["id"] : "";
            $id_people = isset($row["id_people"]) ? $row["id_people"] : "";
            $registered = isset($row["registered"]) ? $row["registered"] : "";
            $active = isset($row["active"]) ? $row["active"] : "";
        }
        
        
        ?>
        <div>
            <label for="selection">Selekcije štafete</label><br>
            <select name="selection[]" id="selection" multiple>
                <?php

                // Fetch all selections
                $stmt = $conn->prepare("SELECT id, title FROM selection");
                $stmt->execute();
                $selectionResult = $stmt->get_result();

                // Fetch the selected athlete's selections
                $stmt = $conn->prepare("SELECT id_selection FROM athlete_selection WHERE id_athlete=?");
                $stmt->bind_param("i", $id_athlete);
                $stmt->execute();
                $selectionResultSelected = $stmt->get_result();

                // Create an array to hold selected id_selection values
                $selectedIds = [];
                while ($selectionSelected = $selectionResultSelected->fetch_assoc()) {
                    $selectedIds[] = $selectionSelected['id_selection'];
                }

                // Loop through all selections and check if the current selection is selected
                while ($selection = $selectionResult->fetch_assoc()) {
                    // Check if the id from selectionResult is in the selectedIds array
                    $isSelected = in_array($selection['id'], $selectedIds) ? 'selected' : '';
                    echo "<option value='{$selection['id']}' {$isSelected}>{$selection['title']}</option>";
                }

                ?>
            </select>
        </div>
        <div>
            <label for="discipline">Discipline štafete</label><br>
            <select name="discipline[]" id="discipline" multiple>
                <?php

                // Fetch all disciplines
                $stmt = $conn->prepare("SELECT id, title FROM discipline");
                $stmt->execute();
                $disciplineResult = $stmt->get_result();

                // Fetch the selected athlete's disciplines
                $stmt = $conn->prepare("SELECT id_discipline FROM athlete_discipline WHERE id_athlete=?");
                $stmt->bind_param("i", $id_athlete);
                $stmt->execute();
                $disciplineResultSelected = $stmt->get_result();

                // Create an array to hold selected id_discipline values
                $selectedDisciplineIds = [];
                while ($disciplineSelected = $disciplineResultSelected->fetch_assoc()) {
                    $selectedDisciplineIds[] = $disciplineSelected['id_discipline'];
                }

                // Loop through all disciplines and check if the current discipline is selected
                while ($discipline = $disciplineResult->fetch_assoc()) {
                    // Check if the id from disciplineResult is in the selectedDisciplineIds array
                    $isSelected = in_array($discipline['id'], $selectedDisciplineIds) ? 'selected' : '';
                    echo "<option value='{$discipline['id']}' {$isSelected}>{$discipline['title']}</option>";
                }

                ?>
            </select>
        </div>
        <div>
            
            <label for="discipline">Člani štafete</label><br>
            <select name="people[]" id="people" multiple>
                <?php

                $stmt = $conn->prepare("SELECT id, CONCAT(surname, ' ', name) AS full_name FROM people WHERE name IS NOT NULL ORDER BY full_name");
                $stmt->execute();
                $peopleResult = $stmt->get_result();

                $stmt = $conn->prepare("SELECT id_people FROM relays WHERE id_people_relay=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $peopleResultSelected = $stmt->get_result();

                // Create an array to hold selected id_discipline values
                $selectedPeopleIds = [];
                while ($peopleSelected = $peopleResultSelected->fetch_assoc()) {
                    $selectedPeopleIds[] = $peopleSelected['id_people'];
                }

                // Loop through all disciplines and check if the current discipline is selected
                while ($people = $peopleResult->fetch_assoc()) {
                    // Check if the id from disciplineResult is in the selectedDisciplineIds array
                    $isSelected = in_array($people['id'], $selectedPeopleIds) ? 'selected' : '';
                    echo "<option value='{$people['id']}' {$isSelected}>{$people['full_name']}</option>";
                }

                ?>
            </select>
        </div><br>

        <label for="image">Slika osebe: </label>
        <input type="file" name="image" id="image" value="<?php echo $id_image; ?>"><br>
        <input type="submit" value="Shrani">
        
    <?php
    
    } elseif ($action === "delete" && $id > 0) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            if ($id > 0) {
                // Begin a transaction to ensure atomicity
                $conn->begin_transaction();
            
                try {
                    // Delete from athlete where id_people matches the posted id
                    $stmt_athlete = $conn->prepare("DELETE FROM athlete WHERE id_people = ?");
                    $stmt_athlete->bind_param("i", $id);
                    $stmt_athlete->execute();
                    $stmt_athlete->close();

                    $sql = "SELECT * FROM athlete WHERE id_people=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result= $stmt->get_result();

                    $id_athlete = "";
                    if($row = $result->fetch_assoc()) $id_athlete = $row["id"];
            
                    // Delete related records from athlete_selection where id_athlete matches the deleted athlete's id
                    $stmt_selection = $conn->prepare("DELETE FROM athlete_selection WHERE id_athlete = ?");
                    $stmt_selection->bind_param("i", $id_athlete);
                    $stmt_selection->execute();
                    $stmt_selection->close();
            
                    // Delete related records from athlete_discipline where id_athlete matches the deleted athlete's id
                    $stmt_discipline = $conn->prepare("DELETE FROM athlete_discipline WHERE id_athlete = ?");
                    $stmt_discipline->bind_param("i", $id_athlete);
                    $stmt_discipline->execute();
                    $stmt_discipline->close();
            
                    // Delete from coach where id_people matches the posted id
                    $stmt_coach = $conn->prepare("DELETE FROM coach WHERE id = ?");
                    $stmt_coach->bind_param("i", $id);
                    $stmt_coach->execute();
                    $stmt_coach->close();
            
                    // Delete from referees where id_people matches the posted id
                    $stmt_referees = $conn->prepare("DELETE FROM referees WHERE id_people = ?");
                    $stmt_referees->bind_param("i", $id);
                    $stmt_referees->execute();
                    $stmt_referees->close();
            
                    // Finally, delete from people table
                    $stmt_people = $conn->prepare("DELETE FROM people WHERE id = ?");
                    $stmt_people->bind_param("i", $id);
                    if ($stmt_people->execute()) {
                        // Commit the transaction if everything was successful
                        $conn->commit();
                        echo "Oseba uspešno izbrisana in vse povezane podatke.";
                    } else {
                        throw new Exception("Napaka pri brisanju osebe.");
                    }
            
                    // Close the final statement for people
                    $stmt_people->close();
            
                } catch (Exception $e) {
                    // Rollback if any error occurs
                    $conn->rollback();
                    echo "Napaka pri brisanju: " . $e->getMessage();
                }
            } else {
                echo "Napaka: Neveljaven ID osebe.";
            }
            
        }

    } else {
        echo "Napaka!";
    }

}
?>


</body>
</html>
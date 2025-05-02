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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

</header>
<body>
    
<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['people']) ? (int)$_POST['people'] : 0; // Selected news ID

    if ($action === "save") {
        
        //FORM za dodajanje osebe
        ?>
        
        <form action="add-people.php" method="POST" enctype="multipart/form-data">
            
            <h3>Podatki osebe</h3>

            <label for="name">Ime: </label>
            <input type="text" name="name" id="name"><br>

            <label for="surname">Priimek: </label>
            <input type="text" name="surname" id="surname"><br>

            <label for="gender">Spol: </label>
            <select name="gender" id="gender">
                <option value="m">Moški</option>
                <option value="z">Ženska</option>
            </select><br>

            <label for="date">Datum rojstva: </label>
            <input type="date" name="dateOfBirth" id="dateOfBirth"><br>

            <label for="description">Kratek opis osebe: </label>
            <textarea name="description" id="description" style="resize:none" height="30px" width="100px"></textarea><br>

            <label for="athlete">Atlet: </label>
            <input type="checkbox" name="athlete" id="athlete" value="athlete"><br>
            <label for="coach">Trener: </label>
            <input type="checkbox" name="coach" id="coach" value="coach"><br>
            <label for="referee">Sodnik: </label>
            <input type="checkbox" name="referee" id="referee" value="referee"><br>

            <label for="image">Slika osebe: </label>
            <input type="file" name="image" id="image" accept=".jpg, image/jpeg">


            <img id="preview" src="<?php echo !empty($id_image) ? '../gallery/' . $id_image : ''; ?>" 
                alt="Predogled slike" 
                style="max-width: 200px; display: <?php echo !empty($id_image) ? 'block' : 'none'; ?>;" />

            <h3>Podatki atleta</h3>

            <label for="active">Aktiven: </label>
            <input type="checkbox" name="active" id="active" value="1"><br>

            <label for="registered">Registriran: </label>
            <input type="checkbox" name="registered" id="registered" value="1"><br>
            <div>
                <label for="selection">Selekcije atleta/inje</label><br>
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
                <label for="discipline">Discipline atleta/inje</label><br>
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

            <h3>Podatki trenerja</h3>
            
            <label for="mail">E-pošta: </label>
            <input type="email" name="mail" id="mail"><br>
            
            <label for="tel">Telefonska številka: </label>
            <input type="tel" id="phone" name="phone"><br>
            
            <label for="location">Kraj delovanja trenerja: </label>
            <select name="location" id="location">
                <option value="Šentjur">Šentjur</option>
                <option value="Dramlje">Dramlje</option>
                <option value="Slivnica">Slivnica</option>
                <option value="Podčetrtek">Podčetrtek</option>
                <option value="Lesično">Lesično</option>
                <option value="Rogatec">Rogatec</option>
            </select>


            <button type="submit">Dodaj</button>
        </form>

        
        <?php

    } elseif ($action === "change" && $id > 0) {
        
        $stmt = $conn->prepare("SELECT * FROM people WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        
        
        $stmt->close();
        ?>
        
        <form action="save-people.php" method="POST" enctype="multipart/form-data">
           
        <h3>Podatki osebe</h3>

        <?php
        
        $sql = "SELECT * FROM people WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        $id = $name = $surname = $gender = $date_of_birth = $id_image = $description = "";

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
        <label for="name">Ime: </label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>"><br>

        <label for="surname">Priimek: </label>
        <input type="text" name="surname" id="surname" value="<?php echo $surname; ?>"><br>

        <label for="gender">Spol: </label>
        <select name="gender" id="gender">
            <option value="m" <?php if($gender == "m") echo "selected"; ?>>Moški</option>
            <option value="z" <?php if($gender == "z") echo "selected"; ?>>Ženska</option>
        </select><br>

        <label for="date">Datum rojstva: </label>
        <input type="date" name="dateOfBirth" id="dateOfBirth" value="<?php echo $date_of_birth; ?>"><br>

        <label for="description">Kratek opis osebe: </label>
        <textarea name="description" id="description" style="resize:none" height="30px" width="100px"><?php echo $description; ?></textarea><br>

        <?php
        
        $sql = "SELECT * FROM athlete WHERE id_people=?";

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("i", $id_people);
        $stmt->execute();
        $result = $stmt->get_result();
        
        ?>

        <label for="athlete">Atlet: </label>
        <input type="checkbox" name="athlete" id="athlete" value="athlete" <?php if($row = $result->fetch_assoc() && isset($row)) echo "checked"; ?>><br>

        <?php
        
        $sql = "SELECT * FROM coach WHERE id=?";

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("i", $id_people);
        $stmt->execute();
        $result = $stmt->get_result();
        
        ?>

        <label for="coach">Trener: </label>
        <input type="checkbox" name="coach" id="coach" value="coach" <?php if($row = $result->fetch_assoc() && isset($row)) echo "checked"; ?>><br>

        <?php
        
        $sql = "SELECT * FROM referees WHERE id_people=?";

        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("i", $id_people);
        $stmt->execute();
        $result = $stmt->get_result();
        
        ?>

        <label for="referee">Sodnik: </label>
        <input type="checkbox" name="referee" id="referee" value="referee" <?php if($row = $result->fetch_assoc() && isset($row)) echo "checked"; ?>><br>

        <?php
        
        $stmt->prepare("SELECT * FROM images WHERE id=?");
        $stmt->bind_param("i", $id_image);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        ?>

        <!-- Implementiraj kodo za spreminjajne slike osebe -->
        <label for="image">Slika osebe: </label>
        <input type="file" name="image" id="image" accept=".jpg, image/jpeg">
        <img id="preview" src="<?php echo '../../../gallery/osebje/' . $id_people . '.jpg'; /*!empty($id_image) ? '../../../gallery/osebje' . $id_people . '.jpg' : '';*/ ?>" alt="Predogled slike" style="max-width: 200px" />

        <h3>Podatki atleta</h3>

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

        <input type="text" name="id_athlete" id="id_athlete" value="<?php echo $id_athlete; ?>" hidden>

        <label for="active">Aktiven: </label>
        <input type="checkbox" name="active" id="active" value="1" <?php if($active == 1) echo "checked"; ?>><br>

        <label for="registered">Registriran: </label>
        <input type="checkbox" name="registered" id="registered" value="1" <?php if($registered == 1) echo "checked"; ?>><br>
        <div>
            <label for="selection">Selekcije atleta/inje</label><br>
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
            <label for="discipline">Discipline atleta/inje</label><br>
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
        </div><br>

        <h3>Podatki trenerja</h3>
        
        <?php
        
        $sql = "SELECT * FROM coach WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_people);
        $stmt->execute();

        $result = $stmt->get_result();

        $id_coach = $mail = $tel = $location = "";

        if ($row = $result->fetch_assoc()) {
            $id_coach = isset($row["id"]) ? $row["id"] : "";
            $mail = isset($row["mail"]) ? $row["mail"] : "";
            $tel = isset($row["tel"]) ? $row["tel"] : "";
            $location = isset($row["location"]) ? $row["location"] : "";
        }
        
        
        ?>

        <label for="mail">E-pošta: </label>
        <input type="email" name="mail" id="mail" value="<?php echo $mail ?>"><br>

        <label for="tel">Telefonska številka: </label>
        <input type="tel" id="phone" name="phone" value="<?php echo $tel ?>"><br>

        <label for="location">Kraj delovanja trenerja: </label>
        <select name="location" id="location">
            <option value="Šentjur" <?php if($location == "Šentjur") echo "selected"; ?>>Šentjur</option>
            <option value="Dramlje" <?php if($location == "Dramlje") echo "selected"; ?>>Dramlje</option>
            <option value="Slivnica" <?php if($location == "Slivnica") echo "selected"; ?>>Slivnica</option>
            <option value="Podčetrtek" <?php if($location == "Podčetrtek") echo "selected"; ?>>Podčetrtek</option>
            <option value="Lesično" <?php if($location == "Lesično") echo "selected"; ?>>Lesično</option>
            <option value="Rogatec" <?php if($location == "Rogatec") echo "selected"; ?>>Rogatec</option>
        </select>

            <button type="submit">Shrani</button>
        </form>
        
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
<script>
Dropzone.autoDiscover = false;

var uploadedImageName = "";

var myDropzone = new Dropzone("#dropzone-image", {
    url: "upload-image.php",
    paramName: "file",
    maxFilesize: 5, // in MB
    acceptedFiles: "image/*",
    maxFiles: 1,
    addRemoveLinks: true,
    init: function () {
        this.on("success", function (file, response) {
            uploadedImageName = response.filename;
            console.log("Image uploaded as:", uploadedImageName);
            
            // Optional: add hidden field to your main form
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "uploaded_image";
            hiddenInput.value = uploadedImageName;
            document.querySelector("form[action='add-people.php']").appendChild(hiddenInput);
        });
    }
});
</script>



<style>
.drop-area {
    border: 2px dashed #ccc;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    margin-top: 5px;
}
.drop-area.highlight {
    border-color: #666;
}
</style>


<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchAccomplishments();
});

function fetchAccomplishments() {
    fetch("fetch-admin-accomplishments.php")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("accomTableBody");
            tableBody.innerHTML = ""; // Clear existing content

            if (data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='10'>Na voljo ni nobene novice</td></tr>";
                return;
            }

            data.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>
                        <a href="save-accom.php?id=${row.id}">
                            <img src="../../../assets/change.svg" alt="" width="20%" height="20%">
                        </a> | 
                        <a href="delete-accom.php?id=${row.id}" onclick="return confirmDeleteAccom(${row.id});">
                            <img src="../../../assets/delete.svg" alt="Delete" width="20%" height="20%">
                        </a>
                    </td>
                    <td>${row.date}</td>
                    <td>${row.fullname || ""}</td>
                    <td>${row.selection || ""}</td>
                    <td>${row.discipline || ""}</td>
                    <td>${row.result_technical || ""}</td>
                    <td>${row.result_time || ""}</td>
                    <td>${row.description || ""}</td>
                    <td>${row.location || ""}</td>
                    <td>${row.gender || ""}</td>
                `;
                tableBody.appendChild(tr);
            });
        })
        .catch(error => console.error("Error fetching accomplishments:", error));
}
</script>

<script>
    function confirmDelete(event) {
        // Check if the delete button was clicked
        if (event.submitter && event.submitter.value === "delete") {
            return confirm("Ste prepričani, da želite izbrisati to novico?");
        }
        return true; // Allow other actions to proceed
    }
</script>

<script>
    // Skrivanje <div> na začetku
    const contentDivs = document.querySelectorAll('.contentDiv');
    contentDivs.forEach(div => {
        div.style.display = 'none';
    });

    // Prikaži <div>
    function showDiv(divId) {
        contentDivs.forEach(div => {
            div.style.display = 'none';
        });

        const divToShow = document.getElementById(divId);
        if (divToShow) {
            divToShow.style.display = 'block';
        }
    }
    showDiv('novice');
</script>

</body>
</html>
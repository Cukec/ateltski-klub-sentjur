<?php

include("../../config.php");

if(isset($_POST)){

    function sanitize_input($data, $conn) {
        $data = trim($data);                  
        $data = stripslashes($data);         
        $data = htmlspecialchars($data);      
        return $conn->real_escape_string($data); 
    }
    
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get and sanitize user input
        $id_people = isset($_POST["id_people"]) ? sanitize_input($_POST["id_people"], $conn) : NULL;
        $name = isset($_POST['name']) ? sanitize_input($_POST['name'], $conn) : NULL;
        $surname = isset($_POST['surname']) ? sanitize_input($_POST['surname'], $conn) : NULL;
        $gender = isset($_POST['gender']) ? sanitize_input($_POST['gender'], $conn) : NULL;
        $date_of_birth = isset($_POST['dateOfBirth']) ? sanitize_input($_POST['dateOfBirth'], $conn) : NULL;
        $id_image = NULL;
        //$id_image = isset($_POST['image']) ? (int) $_POST['image'] : NULL; // Convert to integer
        $description = isset($_POST['description']) ? sanitize_input($_POST['description'], $conn) : NULL;
    
        // Validate required fields
        if (empty($surname) || empty($gender)) {
            die("Surname and gender are required fields!");
        }

        // Check and handle image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileType = mime_content_type($fileTmpPath);

    if ($fileType !== 'image/jpeg') {
        die("Napaka: Dovoljene so samo JPG datoteke.");
    }

    // Ustvari novo sliko velikosti 100x120
    $src = imagecreatefromjpeg($fileTmpPath);
    if (!$src) {
        die("Napaka pri odpiranju slike.");
    }

    $dstWidth = 100;
    $dstHeight = 120;
    $dst = imagecreatetruecolor($dstWidth, $dstHeight);

    $width = imagesx($src);
    $height = imagesy($src);

    imagecopyresampled($dst, $src, 0, 0, 0, 0, $dstWidth, $dstHeight, $width, $height);

    $imagePath = "../../../gallery/osebje/";
    if (!is_dir($imagePath)) {
        mkdir($imagePath, 0777, true);
    }

    $fullPath = $imagePath . $id_people . ".jpg";

    // Izbriši staro sliko, če obstaja
    if (file_exists($fullPath)) {
        unlink($fullPath);
    }

    // Shrani novo sliko
    imagejpeg($dst, $fullPath, 90);

    // Počisti iz pomnilnika
    imagedestroy($src);
    imagedestroy($dst);

    echo "Slika uspešno naložena, preoblikovana na 100x120 in prepisana.<br>";
} else {
    echo "Slika ni bila naložena ali je prišlo do napake.<br>";
}




    
        $sql = "UPDATE people SET name = ?, surname = ?, gender = ?, date_of_birth = ?, id_image = ?, description = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisi", $name, $surname, $gender, $date_of_birth, $id_image, $description, $id_people);
    
        // Execute the statement
        if ($stmt->execute()) {
            echo "Uspešna posodobitev podatkov osebe!<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    
        // Close connections
        $stmt->close();
    }
    
    

    //Urejanje podatkov za atleta/trenerja/sodnika

    if(isset($_POST['athlete'])){

        $id_athlete = isset($_POST['id_athlete']) ? sanitize_input($_POST['id_athlete'], $conn) : NULL;
        $active = isset($_POST['active']) ? sanitize_input($_POST['active'], $conn) : 0;
        $registered = isset($_POST['registered']) ? sanitize_input($_POST['registered'], $conn) : 0;


        // Check if the athlete already exists based on unique criteria (e.g., id_people)
        $sql_check = "SELECT COUNT(*) FROM athlete WHERE id_people = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $id_people);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count == 0) {  // If no existing athlete record, insert new one
            $sql_insert = "INSERT INTO athlete (registered, active, id_people) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iii", $registered, $active, $id_people);
        
            // Execute the insert statement
            if ($stmt_insert->execute()) {
                echo "New athlete record inserted successfully! <br>";
            } else {
                echo "Error: " . $stmt_insert->error . '<br>';
            }
        
            // Close insert statement
            $stmt_insert->close();
        
            // Get the newly inserted athlete ID
            $id_athlete = $conn->insert_id;
        } else {
            // Athlete already exists, update active and registered status
            $sql_update = "UPDATE athlete SET active = ?, registered = ? WHERE id_people = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("iii", $active, $registered, $id_people);
        
            if ($stmt_update->execute()) {
                echo "Athlete record updated successfully! <br>";
            } else {
                echo "Error: " . $stmt_update->error . '<br>';
            }
        
            // Close update statement
            $stmt_update->close();
        }
        

        
        

        if (!empty($_POST['discipline'])) {

            $stmt_check = $conn->prepare("SELECT COUNT(*) FROM athlete_discipline WHERE id_athlete = ? AND id_discipline = ?");
            $stmt_insert = $conn->prepare("INSERT INTO athlete_discipline (id_athlete, id_discipline) VALUES (?, ?)");

            foreach ($_POST['discipline'] as $discipline) {
                $sanitized_discipline = htmlspecialchars($discipline);

                // Check if the discipline already exists for the athlete
                $stmt_check->bind_param("ii", $id_athlete, $sanitized_discipline);
                $stmt_check->execute();
                $stmt_check->store_result(); // ✅ Store result BEFORE fetch()
                $stmt_check->bind_result($count);
                $stmt_check->fetch();

                if ($count == 0) { // If no existing record, insert new one
                    $stmt_insert->bind_param("ii", $id_athlete, $sanitized_discipline);
                    if ($stmt_insert->execute()) {
                        echo "Uspešen vnos discipline atleta: " . $sanitized_discipline . "<br>";
                    } else {
                        echo "Napaka pri vnosu discipline atleta: " . $sanitized_discipline . "<br>";
                    }
                } else {
                    echo "Disciplina '" . $sanitized_discipline . "' je že povezana z atletom.<br>";
                }

                $stmt_check->free_result(); // ✅ Free result to avoid sync issues
            }

            // Close statements
            $stmt_check->close();
            $stmt_insert->close();


        }

        if (!empty($_POST['selection'])) {
            $stmt_check = $conn->prepare("SELECT COUNT(*) FROM athlete_selection WHERE id_athlete = ? AND id_selection = ?");
            $stmt_insert = $conn->prepare("INSERT INTO athlete_selection (id_athlete, id_selection) VALUES (?, ?)");

            foreach ($_POST['selection'] as $selection) {
                $sanitized_selection = htmlspecialchars($selection);

                // Check if the selection already exists for the athlete
                $stmt_check->bind_param("ii", $id_athlete, $sanitized_selection);
                $stmt_check->execute();
                $stmt_check->bind_result($count);
                $stmt_check->fetch();  // Fetch result to store count value

                if ($count == 0) { // If no existing record, insert new one
                    $stmt_insert->bind_param("ii", $id_athlete, $sanitized_selection);
                    if ($stmt_insert->execute()) {
                        echo "Uspešen vnos izbora atleta: " . $sanitized_selection . "<br>";
                    } else {
                        echo "Napaka pri vnosu izbora atleta: " . $sanitized_selection . "<br>";
                    }
                } else {
                    echo "Izbor '" . $sanitized_selection . "' je že povezan z atletom.<br>";
                }

                // Clear results of the SELECT statement after use to prevent "commands out of sync"
                $stmt_check->free_result(); // Free the result set before reusing the statement for the next loop iteration
            }

            // Close statements after finishing the loop
            $stmt_check->close();
            $stmt_insert->close();



        }


    }else{

        echo "Napak pri vnosu podatkov!<br>";

    }

    //Dodajanje trenerja

    if(isset($_POST['coach'])){

        // Step 1: Check if a coach with the same id_people exists
        $sql_check = "SELECT id FROM coach WHERE id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $id_people);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Step 2: Coach exists, perform update
            $sql_update = "UPDATE coach SET mail=?, tel=?, location=? WHERE id=?";
            $stmt_update = $conn->prepare($sql_update);

            // Sanitize and bind parameters
            $mail = isset($_POST['mail']) ? sanitize_input($_POST['mail'], $conn) : NULL;
            $tel = isset($_POST['phone']) ? sanitize_input($_POST['phone'], $conn) : NULL;
            $location = isset($_POST['location']) ? sanitize_input($_POST['location'], $conn) : NULL;

            $stmt_update->bind_param("sssi", $mail, $tel, $location, $id_people);

            if ($stmt_update->execute()) {
                echo "Uspešen vnos trenerja (posodobljeno)<br>";
            } else {
                echo "Napaka pri posodobitvi trenerja: " . $stmt_update->error . "<br>";
            }

            $stmt_update->close();
        } else {
            // Step 3: Coach does not exist, perform insert
            $sql_insert = "INSERT INTO coach (id, mail, tel, location) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);

            // Bind parameters
            $stmt_insert->bind_param("isss", $id_people, $mail, $tel, $location);

            if ($stmt_insert->execute()) {
                echo "Uspešen vnos trenerja (dodano novo)<br>";
            } else {
                echo "Napaka pri vnosu trenerja: " . $stmt_insert->error . "<br>";
            }

            $stmt_insert->close();
        }

        // Close the check statement
        $stmt_check->close();



    }else{

        echo "Napaka pri vnosu podatkov!<br>";

    }

    if(isset($_POST['referee'])){

        // Step 1: Check if a referee with the same id_people exists
        $sql_check = "SELECT id FROM referees WHERE id_people = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $id_people);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Step 2: Referee exists, perform update
            $sql_update = "UPDATE referees SET id_people=? WHERE id_people=?";
            $stmt_update = $conn->prepare($sql_update);

            // Bind parameters
            $stmt_update->bind_param("ii", $id_people, $id_people);

            if ($stmt_update->execute()) {
                echo "Uspešen vnos sodnika (posodobljeno)<br>";
            } else {
                echo "Napaka pri posodobitvi sodnika: " . $stmt_update->error . "<br>";
            }

            $stmt_update->close();
        } else {
            // Step 3: Referee does not exist, perform insert
            $sql_insert = "INSERT INTO referees (id_people) VALUES (?)";
            $stmt_insert = $conn->prepare($sql_insert);

            // Bind parameter
            $stmt_insert->bind_param("i", $id_people);

            if ($stmt_insert->execute()) {
                echo "Uspešen vnos sodnika (dodano novo)<br>";
            } else {
                echo "Napaka pri vnosu sodnika: " . $stmt_insert->error . "<br>";
            }

            $stmt_insert->close();
        }

        // Close the check statement
        $stmt_check->close();


    }else{

        echo "Napaka pri vnosu podatkov!<br>";

    }

}

?>
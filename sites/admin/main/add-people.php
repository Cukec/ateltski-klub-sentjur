<?php

include("../../config.php");

if(isset($_POST)){

    function sanitize_input($data, $conn) {
        $data = trim($data);                  
        $data = stripslashes($data);         
        $data = htmlspecialchars($data);      
        return $conn->real_escape_string($data); 
    }

    $msgs = [];
    
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get and sanitize user input
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
    
        // Prepare the INSERT statement
        $sql = "INSERT INTO people (name, surname, middle_name, gender, date_of_birth, id_image, description)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
    
        // Bind parameters ("s" for string, "i" for integer)
        $stmt->bind_param("sssssis", $name, $surname, $middle_name, $gender, $date_of_birth, $id_image, $description);
    
        // Execute the statement
        if ($stmt->execute()) {
            $msgs[] = "Uspešno dodajanje vsebine osebe!";
        } else {
            $msgs[] = "Napaka pri dodajanje vsebine osebe! Poskusite znova...";
        }

        // After inserting into people
        $id_people = $conn->insert_id;

        // Save image as "1234.jpg" in /osebje folder manually before or after this step

        // Check and handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileType = mime_content_type($fileTmpPath);

            if ($fileType !== 'image/jpeg') {
                die("Napaka: Dovoljene so samo JPG datoteke.");
            }

            // Resize the image to 300x300
            $src = imagecreatefromjpeg($fileTmpPath);
            if (!$src) {
                die("Napaka pri odpiranju slike.");
            }

            $dst = imagecreatetruecolor(100, 120);
            $width = imagesx($src);
            $height = imagesy($src);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, 300, 300, $width, $height);

            $imagePath = "../../../gallery/osebje/";
            if (!is_dir($imagePath)) {
                mkdir($imagePath, 0777, true);
            }

            $fullPath = $imagePath . $id_people . ".jpg";
            imagejpeg($dst, $fullPath, 90);

            imagedestroy($src);
            imagedestroy($dst);

            $msgs[] = "Uspešno nalaganje in shranjevanje slike!";
        } else {
            $msgs[] = "Napaka pri nalaganju slike ali pa ta ni bila naložena!";
        }


        
    }
    
    

    //Urejanje podatkov za atleta/trenerja/sodnika

    if(isset($_POST['athlete'])){

        $id_people = $conn->insert_id;
        $active = isset($_POST['active']) ? sanitize_input($_POST['active'], $conn) : 0;
        $registered = isset($_POST['registered']) ? sanitize_input($_POST['registered'], $conn) : 0;

        $sql = "INSERT INTO athlete (registered, active, id_people) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $registered, $active, $id_people);

        // Execute the statement
        if ($stmt->execute()) {
            $msgs[] = "Uspešno dodajanje vsebine atleta!";
        } else {
            $msgs[] = "Napaka pri dodajanju vsebine atleta! Poskusite znova...";
        }
    
        // Close connections
        $stmt->close();

        $id_athlete = $conn->insert_id;

        if (!empty($_POST['discipline'])) {

            $stmt = $conn->prepare("INSERT INTO athlete_discipline (id_athlete, id_discipline) VALUES (?, ?)");
            
            foreach ($_POST['discipline'] as $discipline) {
                $sanitized_discipline = htmlspecialchars($discipline); 
                $stmt->bind_param("ii", $id_athlete, $sanitized_discipline);
                if($stmt->execute()){
                    $msgs[] = "Uspešeno vnašanje disciplin atleta!";
                }else $msgs[] = "Napaka pri vnosu disciplin atleta!";
            }
        }

        if (!empty($_POST['selection'])) {
            $stmt = $conn->prepare("INSERT INTO athlete_selection (id_athlete, id_selection) VALUES (?, ?)");
            
            foreach ($_POST['selection'] as $selection) {
                $sanitized_selection = htmlspecialchars($selection); 
                $stmt->bind_param("ii", $id_athlete, $sanitized_selection);
                if($stmt->execute()){
                    $msgs[] = "Uspešeno vnašanje disciplin atleta!";
                }else $msgs[] = "Napaka pri vnosu disciplin atleta!";
            }
        }


    }else{

        $msgs[] = "(opozorilo) Podatki za atleta niso bili vnešeni!";

    }

    //Dodajanje trenerja

    if(isset($_POST['coach'])){

        $id_people = $conn->insert_id;

        $sql = "INSERT INTO coach (id, mail, tel, location) VALUES (?, ?, ?, ?)";

        $mail = isset($_POST['mail']) ? sanitize_input($_POST['mail'], $conn) : NULL;
        $tel = isset($_POST['phone']) ? sanitize_input($_POST['phone'], $conn) : NULL;
        $location = isset($_POST['location']) ? sanitize_input($_POST['location'], $conn) : NULL;

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $id_people, $mail, $tel, $location);

        if($stmt->execute()){
            $msgs[] = "Uspešno vnašanje trenerja!";
        }else $msgs[] = "Napaka pri vnosu trenerja!";

    }else{

        $msgs[] = "(opozorilo) Podatki trenerja niso bili vnešeni!";

    }

    if(isset($_POST['referee'])){

        $id_people = $conn->insert_id;

        $sql = "INSERT INTO referees (id, id_people) VALUES (NULL, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_people,);

        if($stmt->execute()){
            $msgs[] = "Uspešno vnašanje sodnika!";
        }else $msgs[] = "Napaka pri vnosu sodnika!";

    }else{

        $msgs[] = "(opozorilo) Podatki sodnika niso bili vnešeni!";

    }

}

$error = "false";

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));


?>
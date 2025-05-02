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
        $id = isset($_POST['id']) ? sanitize_input($_POST['id'], $conn) : 0;
        $name = isset($_POST['name']) ? sanitize_input($_POST['name'], $conn) : NULL;
        $surname = isset($_POST['title']) ? sanitize_input($_POST['title'], $conn) : NULL;
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
        $sql = "UPDATE people SET name=?, surname=?, middle_name=?, gender=?, date_of_birth=?, id_image=?, description=? WHERE id=?";
    
        $stmt = $conn->prepare($sql);
    
        // Bind parameters ("s" for string, "i" for integer)
        $stmt->bind_param("sssssisi", $name, $surname, $middle_name, $gender, $date_of_birth, $id_image, $description, $id);
    
        // Execute the statement
        if ($stmt->execute()) {
            echo "New record inserted successfully!<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    
        // Close connections
        $stmt->close();
    }
    
    $id_people = $id;
    $active = isset($_POST['active']) ? sanitize_input($_POST['active'], $conn) : 0;
    $registered = isset($_POST['registered']) ? sanitize_input($_POST['registered'], $conn) : 0;

    $sql = "UPDATE athlete SET registered=?, active=? WHERE id_people=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $registered, $active, $id_people);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record inserted successfully! <br>";
    } else {
        echo "Error: " . $stmt->error . '<br>';
    }
    
    // Close connections
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM athlete WHERE id_people = ?");
    $stmt->bind_param("i", $id_people);
    $stmt->execute();

    $result = $stmt->get_result(); // Fetch the result set
    $row = $result->fetch_assoc();

    if ($row) { // No need for isset(), just check if $row is not null
        $id_athlete = $row["id"];
    }

    
    // Close connections
    $stmt->close();

    

    if (!empty($_POST['discipline'])) {

        $stmt = $conn->prepare("UPDATE athlete_discipline SET id_discipline=? WHERE id_athlete=?");
            
        foreach ($_POST['discipline'] as $discipline) {
            $sanitized_discipline = htmlspecialchars($discipline); 
            $stmt->bind_param("ii", $id_athlete, $sanitized_discipline);
            if($stmt->execute()){
                echo "Uspešen vnos disciplin štafete<br>";
            }else echo "Napaka pri vnosu disciplin štafete<br>";
        }
    }

    if (!empty($_POST['selection'])) {
        $stmt = $conn->prepare("UPDATE athlete_selection SET id_selection=? WHERE id_athlete=?");
            
        foreach ($_POST['selection'] as $selection) {
            $sanitized_selection = htmlspecialchars($selection); 
            $stmt->bind_param("ii", $sanitized_selection, $id_athlete);
            if($stmt->execute()){
                echo "Uspešen vnos disciplin štafete<br>";
            }else echo "Napaka pri vnosu disciplin štafete<br>";
        }
    }

    if (!empty($_POST['people'])) {
        $stmt = $conn->prepare("UPDATE relays SET id_people=? WHERE id_people_relay=?");
            
        foreach ($_POST['people'] as $person) {
            $sanitized_person = htmlspecialchars($person); 
            $stmt->bind_param("ii", $sanitized_person, $id_people);
            if($stmt->execute()){
                echo "Uspešen vnos ateltov štafete<br>";
            }else echo "Napaka pri vnosu atletov štefete<br>";
        }
    }

    $conn->close();
}

?>
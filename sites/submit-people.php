<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Get the form data from POST request
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['birthday']);

    // Get the admin ID (you may need to adjust this if you have a session or a different way of getting the admin ID)
    $id_admin = 1; // This is a placeholder. Replace with the actual ID or session-based logic if necessary.
    
    // Prepare the SQL query to insert the new event into the database
    $sql = "INSERT INTO people (name, surname, middle_name, gender, date_of_birth, description) 
            VALUES ('$name', '$surname', '$middle_name', '$gender', '$date_of_birth', '$description')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "New event added successfully!";
        header("Location: admin.php?status=success");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}

?>
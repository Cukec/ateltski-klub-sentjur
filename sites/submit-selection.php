<?php 

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Get the form data from POST request
    $title = mysqli_real_escape_string($conn, $_POST['title']);


    $id_admin = 1; // This is a placeholder. Replace with the actual ID or session-based logic if necessary.
    
    // Prepare the SQL query to insert the new event into the database
    $sql = "INSERT INTO selection (title) 
            VALUES ('$title')";

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
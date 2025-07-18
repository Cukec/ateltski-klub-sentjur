<?php
// Include the database configuration file
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    echo '<pre>';
        print_r($_POST);
        echo '</pre>';

    // Get the form data from POST request
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $date_start = mysqli_real_escape_string($conn, $_POST['date_start']);
    $date_end = mysqli_real_escape_string($conn, isset($_POST['date_end']) ? $_POST['date_end'] : NULL);  // Allowing null

    // Get the admin ID (you may need to adjust this if you have a session or a different way of getting the admin ID)
    $id_admin = 1; // This is a placeholder. Replace with the actual ID or session-based logic if necessary.
    
    // Prepare the SQL query to insert the new event into the database
    $sql = "INSERT INTO events (type, title, content, location, date_start, date_end, id_admin) 
            VALUES ('$type', '$title', '$content', '$location', '$date_start', " . ($date_end ? "'$date_end'" : "NULL") . ", '$id_admin')";

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

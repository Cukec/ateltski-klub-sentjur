<?php 

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Get the form data from POST request
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $query = "SELECT MAX(num_out) AS max_num_out FROM discipline";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $max_num_out = $row['max_num_out'];
        echo "The maximum value is: " . $max_num_out;
    } else {
        echo "No results found.";
    }

    $num_out = $max_num_out + 1;


    $id_admin = 1; // This is a placeholder. Replace with the actual ID or session-based logic if necessary.
    
    // Prepare the SQL query to insert the new event into the database
    $sql = "INSERT INTO discipline (title, type, num_out) 
            VALUES ('$title', '$type', '$num_out')";

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
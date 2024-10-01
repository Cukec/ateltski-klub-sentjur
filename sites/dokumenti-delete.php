<?php
// dokumenti-delete.php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Check if the file exists and delete it
    if (file_exists($file)) {
        unlink($file); // Delete the file
        header('Location: dokumenti.php'); // Redirect back to the documents page
        exit;
    } else {
        echo "File does not exist.";
    }
} else {
    echo "No file specified.";
}
?>

<?php
// Handle the PDF file upload
if (isset($_POST["submit"])) {

    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {

        // Get file details
        $fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
        $fileName = $_FILES['fileToUpload']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Only allow PDF uploads
        if ($fileExtension !== 'pdf') {
            echo "Sorry, only PDF files are allowed.";
            exit;
        }

        // Get the selected folder from the form
        $selectedFolder = isset($_POST['selectedFolder']) ? $_POST['selectedFolder'] : '';

        // Ensure the folder is valid and exists
        if (!is_dir($selectedFolder)) {
            echo "Sorry, the selected folder does not exist.";
            exit;
        }

        // Define the path to save the file in the selected folder
        $outputFilePath = $selectedFolder . '/' . basename($fileName);

        // Save the file content
        if (move_uploaded_file($fileTmpPath, $outputFilePath)) {
            echo "File successfully saved to " . $outputFilePath;
        } else {
            echo "Sorry, there was an error saving the file.";
            exit;
        }

        // Redirect back to the main page after upload
        header("Location: dokumenti.php");
        exit;
    }
}
?>

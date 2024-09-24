<?php
// Check if the form was submitted
if (isset($_POST["submit"])) {

    // Check if a file was uploaded and has no errors
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {

        // Get file information
        $fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
        $fileName = $_FILES['fileToUpload']['name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $fileType = $_FILES['fileToUpload']['type'];

        // Check if the uploaded file is a PDF
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExtension !== 'pdf') {
            echo "Sorry, only PDF files are allowed.";
            exit;
        }

        // Read the content of the uploaded PDF file
        $fileContent = file_get_contents($fileTmpPath);

        // Define the path to save the file in the "documents" folder one directory back
        $outputFilePath = '../documents/' . basename($fileName);

        // Save the file content to the specified file path
        if (file_put_contents($outputFilePath, $fileContent)) {
            echo "File content successfully saved to " . $outputFilePath;
        } else {
            echo "Sorry, there was an error saving the file.";
            exit;
        }

        // Redirect back to the previous page
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "No referring page found.";
        }

    } else {
        echo "No file uploaded or there was an error during the upload.";
    }
}
?>

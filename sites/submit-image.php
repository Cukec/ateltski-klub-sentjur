<?php 

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<pre>';
    print_r($_POST);
    print_r($_FILES);
    echo '</pre>';

    // Base directory for uploads
    $baseUploadDirectory = '../baza/slike/';
    
    // Get and sanitize selected folder
    $selectedFolder = isset($_POST['folder']) ? $_POST['folder'] : 'galerija'; // Default to 'galerija'
    $selectedFolder = preg_replace('/[^a-zA-Z0-9_-]/', '', $selectedFolder);

    // Construct the upload directory
    $uploadDirectory = $baseUploadDirectory . $selectedFolder . '/';

    // Create the folder if it doesn't exist
    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0777, true)) {
            die("Failed to create directory: $uploadDirectory");
        }
    }

    // Handle the uploaded file
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']); // Ensure we only get the file name
        $destination = $uploadDirectory . $fileName;

        // Move the file to the target folder
        if (move_uploaded_file($fileTmpPath, $destination)) {
            echo "File uploaded successfully to: " . $destination;

            // Escape the URL for safe database insertion
            $imagePath = mysqli_real_escape_string($conn, $selectedFolder . '/' . $fileName);

            // Insert the file URL into the database
            $sql = "INSERT INTO images (url) VALUES ('$imagePath')";

            if ($conn->query($sql) === TRUE) {
                echo "New event added successfully!";
                header("Location: admin.php?status=success");
                exit;
            } else {
                echo "Database Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error moving the file to: $destination";
        }
    } else {
        echo "No file uploaded or an error occurred during upload.";
    }

    // Close the database connection
    $conn->close();
}
?>

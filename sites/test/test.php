<?php
require_once "../../config.php"; // Ensure database connection is included

if (!empty($_FILES['file']) && !empty($_POST['archive_name'])) {
    $archiveName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['archive_name']); // Clean folder name
    $uploadDir = "../../../gallery/galerija/" . $archiveName . "/";

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES["file"]["name"]);
    $targetFile = $uploadDir . $fileName;
    $fileUrl = "galerija/" . $archiveName . "/" . $fileName; // Store relative URL

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Insert into test_image table
        $stmt = $conn->prepare("INSERT INTO test_image (url) VALUES (?)");
        $stmt->bind_param("s", $fileUrl);
        $stmt->execute();
        $stmt->close();

        echo json_encode(["status" => "success", "file" => $fileName, "url" => $fileUrl]);
    } else {
        echo json_encode(["status" => "error", "message" => "Upload failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing file or archive name"]);
}
?>

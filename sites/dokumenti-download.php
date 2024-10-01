<?php
// dokumenti-download.php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Check if the file exists
    if (file_exists($file)) {
        // Set headers to initiate a download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        flush(); // Flush system output buffer
        readfile($file);
        exit;
    } else {
        echo "File does not exist.";
    }
} else {
    echo "No file specified.";
}
?>

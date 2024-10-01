<?php
// Function to get the list of folders in the documents directory
function getFolders($directory) {
    $result = [];
    $files = scandir($directory);

    foreach ($files as $file) {
        $filePath = $directory . "/" . $file;
        
        // Only include directories (and exclude . and ..)
        if (is_dir($filePath) && $file != "." && $file != "..") {
            $result[] = [
                'name' => $file,
                'path' => $file
            ];
        }
    }

    return $result;
}

// Start directory (the documents folder)
$startDir = "../documents";
$folders = getFolders($startDir);

// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($folders);
?>

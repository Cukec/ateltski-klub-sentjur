<?php
// Recursive function to get the directory structure as an associative array
function getFileTree($directory) {
    $result = [];
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $filePath = $directory . "/" . $file;

            // If it's a directory, recursively fetch its contents
            if (is_dir($filePath)) {
                $result[] = [
                    'type' => 'directory',
                    'name' => $file,
                    'path' => $filePath,
                    'children' => getFileTree($filePath)
                ];
            } else {
                // If it's a file, add it to the result
                $result[] = [
                    'type' => 'file',
                    'name' => $file,
                    'path' => $filePath
                ];
            }
        }
    }
    return $result;
}

// Start directory (you can customize this)
$startDir = "../documents";
$fileTree = getFileTree($startDir);

// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($fileTree);
?>

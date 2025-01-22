<?php
// Path to the root directory
$directoryPath = '../filegator/repository';

// Check if the directory exists
if (is_dir($directoryPath)) {
    // Open the directory
    $directories = scandir($directoryPath);

    // Filter out `.` and `..`, and keep only directories
    $directories = array_filter($directories, function ($dir) use ($directoryPath) {
        return $dir !== '.' && $dir !== '..' && is_dir($directoryPath . '/' . $dir);
    });

    // Iterate through directories
    foreach ($directories as $dir) {
        // Display the top-level directory as an option
        echo '<option value="' . htmlspecialchars($dir) . '">' . htmlspecialchars($dir) . '</option>';

        // Create a button to show files in this directory
        echo '<button class="show-files" data-dir="' . htmlspecialchars($dir) . '">Show Files in ' . htmlspecialchars($dir) . '</button>';

        // Placeholder for files in this directory (initially hidden)
        echo '<div class="subdirectory-files" id="files-' . htmlspecialchars($dir) . '" style="display:none;">';

        // Get image files inside the directory
        $imageFiles = scandir($directoryPath . '/' . $dir);
        $imageFiles = array_filter($imageFiles, function ($file) use ($directoryPath, $dir) {
            // Check if the file is an image (jpg, jpeg, png, gif, bmp)
            return $file !== '.' && $file !== '..' && is_file($directoryPath . '/' . $dir . '/' . $file) &&
                   in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'bmp']);
        });

        // List each image file as a radio button inside the directory
        foreach ($imageFiles as $image) {
            echo '<p><input type="radio" name="selected-file" value="' . htmlspecialchars($dir . '/' . $image) . '"> ' . htmlspecialchars($image) . '</p>';
        }

        echo '</div>'; // End the div that contains the subdirectory files
    }
} else {
    // If the directory doesn't exist, output a message
    echo '<option value="">Directory not found</option>';
}
?>

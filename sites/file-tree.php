<?php
function displayFileTree($dir) {
    $files = scandir($dir);
    echo '<ul>';
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $fullPath = $dir . '/' . $file;
        if (is_dir($fullPath)) {
            echo '<li class="directory" data-path="' . $fullPath . '">' . htmlspecialchars($file) . '</li>';
            displayFileTree($fullPath);
        } else {
            // Display files with download and delete icons
            echo '<li class="file" data-path="' . $fullPath . '">' . htmlspecialchars($file) . 
                 '<span class="download-icon">⬇️</span>' .
                 '<span class="delete-icon">🗑️</span>' . 
                 '</li>';
        }
    }
    echo '</ul>';
}

displayFileTree('../documents'); // Adjust path as necessary
?>

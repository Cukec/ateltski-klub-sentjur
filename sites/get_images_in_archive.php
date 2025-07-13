<?php
function getImageFiles($dir) {
    $images = [];
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            $file_path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_file($file_path)) {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($ext, $allowed_extensions)) {
                    $images[] = $file;
                }
            }
        }
    }
    sort($images);
    return $images;
}
?>

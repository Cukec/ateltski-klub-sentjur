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

function getArchives($repositoryPath, $page = 1, $perPage = 8) {
    $archives = [];
    if (!is_dir($repositoryPath)) {
        return $archives;
    }

    // Get all folders in the repository
    $folders = array_filter(scandir($repositoryPath), function($item) use ($repositoryPath) {
        return $item !== '.' && $item !== '..' && is_dir($repositoryPath . DIRECTORY_SEPARATOR . $item);
    });

    // Extract year from folder name and sort folders by year (desc)
    usort($folders, function($a, $b) {
        // Extract 4-digit years from folder names
        preg_match('/\b(19|20)\d{2}\b/', $a, $yearA);
        preg_match('/\b(19|20)\d{2}\b/', $b, $yearB);

        $yearA = isset($yearA[0]) ? (int)$yearA[0] : 0;
        $yearB = isset($yearB[0]) ? (int)$yearB[0] : 0;

        // Sort descending: newest to oldest
        return $yearB <=> $yearA;
    });

    $totalArchives = count($folders);
    $start = ($page - 1) * $perPage;
    $pagedFolders = array_slice($folders, $start, $perPage);

    foreach ($pagedFolders as $folder) {
        $folderPath = $repositoryPath . DIRECTORY_SEPARATOR . $folder;
        $images = getImageFiles($folderPath);
        if (count($images) > 0) {
            $archives[] = [
                'title' => $folder,
                'lead_image' => $folder . '/' . $images[0]
            ];
        }
    }

    return [
        'archives' => $archives,
        'total' => $totalArchives,
        'per_page' => $perPage,
        'current_page' => $page,
        'total_pages' => ceil($totalArchives / $perPage)
    ];
}

?>

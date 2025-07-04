<?php
$baseDir = '../gallery/galerija/';
$folders = array_filter(glob($baseDir . '*'), 'is_dir');

if (count($folders) === 0) {
    http_response_code(404);
    exit('No folders found.');
}

// Izberi naključno mapo
$randomFolder = $folders[array_rand($folders)];

// Pridobi slike (jpg, jpeg, png, gif)
$images = glob($randomFolder . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

if (count($images) === 0) {
    http_response_code(404);
    exit('No images found.');
}

// Izberi naključno sliko
$randomImage = $images[array_rand($images)];

// Vrni URL slike
echo $randomImage;

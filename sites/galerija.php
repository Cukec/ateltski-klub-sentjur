<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery Upload</title>
    <link rel="stylesheet" href="styles/galerija.css">
</head>
<body>
<?php include "navigation.php"; include "config.php"; ?>

<section class="galerija-info">
    <div class="description-main">
        <h1>Galerija</h1>
        <hr>
        <p>Skozi leta smo doživeli veliko lepih trenutkov. Skrbno smo jih poskušali čim več ujeti. Spodaj lahko pobrskate po preteklih trenutkih.</p>
    </div>
    <div class="atletska-sola">
        <img src="../assets/camera.png">
    </div>
</section>

<main>
    <div class="gallery-container">
        <?php
        $queryImg = "SELECT * 
        FROM test_image 
        WHERE url LIKE 'galerija/%' AND url NOT LIKE '%male/%'
        ORDER BY 
            CAST(SUBSTRING(url, REGEXP_INSTR(url, '[0-9]{4}'), 4) AS UNSIGNED) DESC
        ";
        $resultImg = $conn->query($queryImg);

        if ($resultImg->num_rows > 0) {
            $imagesByFolder = [];
            while ($row = $resultImg->fetch_assoc()) {
                $trimmedUrl = str_replace("galerija/", "", $row['url']);
                $parts = explode("/", $trimmedUrl);
                $folder = $parts[0]; // The first folder name
                $imagesByFolder[$folder][] = $trimmedUrl;
            }

            $folderCount = 0; // Counter for folders
            foreach ($imagesByFolder as $folder => $images) {
                $style = $folderCount < 5 ? "" : "style='display: none;'"; // Display first 5 folders
                echo "<div class='gallery-folder' $style data-folder-index='$folderCount'>";
                echo "<div class='folder-title' data-gallery-id='$folder'>$folder</div>";
                echo "<div class='folder-description no-description'>S klikom prikažete slike</div>";
                echo "<div class='gallery-images' data-gallery-id='$folder' style='display: none;'>";
                foreach ($images as $image) {
                    echo "<div class='polaroid'>";
                    echo "<img src='../filegator/repository/galerija/$image' alt='$image'>";
                    echo "<div class='caption'>$image</div>";
                    echo "</div>";
                }
                echo "</div>"; // Close gallery-images
                echo "</div>"; // Close gallery-folder
                $folderCount++;
            }

            // Add "Display More Archives" button if more than 5 folders
            if ($folderCount > 5) {
                echo "<button id='display-more-archives' class='centered-button'>Prikaži več</button>";
            }
        } else {
            echo "<p>No images found.</p>";
        }
        ?>
    </div>
</main>

<!-- Modal Section -->
<div id="image-modal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-image" src="" alt="">
    <div class="modal-caption"></div>
    <button class="prev">&lt;</button>
    <button class="next">&gt;</button>
</div>

<?php include("footer.php"); ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const folderTitles = document.querySelectorAll(".folder-title");
        const displayMoreButton = document.getElementById("display-more-archives");
        let currentFolderCount = 5;

        // Toggle folder visibility
        folderTitles.forEach(title => {
            title.addEventListener("click", () => {
                const galleryId = title.getAttribute("data-gallery-id");
                const galleryImages = document.querySelector(`.gallery-images[data-gallery-id='${galleryId}']`);

                if (galleryImages.style.display === "none" || galleryImages.style.display === "") {
                    galleryImages.style.display = "grid";
                    galleryImages.classList.add("visible");
                } else {
                    galleryImages.style.display = "none";
                    galleryImages.classList.remove("visible");
                }
            });
        });

        // Display more archives
        if (displayMoreButton) {
            displayMoreButton.addEventListener("click", () => {
                const hiddenFolders = document.querySelectorAll(`.gallery-folder[data-folder-index]`);
                let shownCount = 0;

                hiddenFolders.forEach(folder => {
                    if (folder.style.display === "none" && shownCount < 5) {
                        folder.style.display = "block";
                        shownCount++;
                    }
                });

                // Hide the button if all folders are shown
                const allFoldersShown = Array.from(hiddenFolders).every(folder => folder.style.display === "block");
                if (allFoldersShown) {
                    displayMoreButton.style.display = "none";
                }
            });
        }
    });
</script>
<script src="gallery.js"></script>
<script src="gallery-modal.js"></script>
</body>
</html>

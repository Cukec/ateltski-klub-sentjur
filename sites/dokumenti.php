<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Tree Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles/dokumenti.css">
</head>
<body>

<?php include"navigation.php"; include"config.php" ?>


    <div class="custom-shape">
        <div class="left-text">
            <h2>uporabni dokumenti</h2>
        </div>
        <div class="vertical-line"></div>
        <div class="right-text">
            <p>
                Skozi leta delovanja AK Šentjur se je nabralo nekaj uporabnih dokumentov. Najdete in jih lahko spodaj, s klikom na datoteko pa jo prenesete.
            </p>
        </div>
    </div>


<div class="file-tree-container">
    <div class="title"><h2>Dokumenti</h2></div>
    <ul class="file-tree" id="fileTree"></ul>
</div>
<script>
$(document).ready(function() {
    // Function to load file tree
    function loadFileTree(path, $parent) {
        $.ajax({
            url: 'fetch-file-tree.php', // PHP script to fetch the file tree
            type: 'GET',
            data: { folder: path },
            dataType: 'json',
            success: function(data) {
                buildFileTree(data, $parent);
            },
            error: function() {
                alert('Error loading file tree');
            }
        });
    }

    // Function to build the file tree from JSON data
    function buildFileTree(data, $parent) {
        data.forEach(function(item) {
            let $li = $('<li></li>').addClass(item.type);
            $li.text(item.name);

            if (item.type === 'folder') {
                $li.addClass('folder');
                let $subTree = $('<ul class="hidden"></ul>');
                $li.append($subTree);

                // Click event to toggle folder open/close
                $li.on('click', function(e) {
                    e.stopPropagation(); // Prevent event bubbling

                    // Check if folder is already open
                    if ($li.hasClass('open')) {
                        $subTree.addClass('hidden'); // Hide subfolder contents
                        $li.removeClass('open'); // Toggle folder to closed state
                    } else {
                        // If the folder is closed, load its contents (if not already loaded)
                        if ($subTree.children().length === 0) {
                            loadFileTree(item.path, $subTree); // Load subfolder contents only if not already loaded
                        }
                        $subTree.removeClass('hidden'); // Show subfolder contents
                        $li.addClass('open'); // Toggle folder to open state
                    }
                });
            } else {
                $li.addClass('file');

                // Attach click event to trigger file download
                $li.on('click', function(e) {
                    e.stopPropagation(); // Prevent event bubbling

                    // Create a hidden download link and trigger download
                    const downloadLink = document.createElement('a');
                    downloadLink.href = item.path; // File path
                    downloadLink.download = item.name; // File name
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                });
            }

            $parent.append($li);
        });
    }

    // Initialize file tree with the desired folder path
    loadFileTree('../documents', $('#fileTree')); // Change this to your target folder path
});
</script>

<?php include "footer.php"; ?>

</body>
</html>

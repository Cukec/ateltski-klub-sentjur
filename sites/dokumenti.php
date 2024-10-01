<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dokumenti</title>

    <style>
        ul {
            list-style-type: none;
            padding-left: 1em; /* Indentation for nested lists */
        }

        li {
            cursor: pointer;
            padding-left: 1em; /* Indentation for arrow and icon */
            position: relative; /* To position the delete icon */
        }

        .directory::before {
            content: '▶'; /* Default closed folder icon (right arrow) */
            display: inline-block;
            margin-right: 0.5em;
        }

        .directory.open::before {
            content: '▼'; /* Open folder icon (down arrow) */
        }

        .directory .folder-icon::before {
            content: '📁'; /* Folder icon */
            margin-right: 0.5em;
        }

        .file::before {
            content: '📄'; /* File icon */
            margin-right: 0.5em;
        }

        .selected {
            background-color: #f0f0f0; /* Highlight selected folder */
        }

        /* Darker background for selected files */
        .file.selected {
            background-color: #d0d0d0; /* Darker highlight for selected files */
        }

        /* Hide subfolder contents by default */
        ul ul {
            display: none; /* Hide nested lists */
        }

        /* When a directory is open, its contents are shown */
        .directory.open + ul {
            display: block; /* Show contents of open directory */
        }
    </style>

</head>
<body>
    <div class="document-img">
        <img src="../assets/documents.png" height="256" width="256">
    </div>
    <article>
        <p>Skozi leta smo shranjevali rezultate, razpise in rekorde. Vse to in uradne dokumente ter razne ostale dokumente.</p>
        <p>Najdete jih spodaj.</p>
    </article>

    <div>
        <h1>Upload PDF and View File Tree</h1>

        <!-- Form for uploading PDF -->
        <form action="dokumenti-upload.php" method="POST" enctype="multipart/form-data">
            <!-- Hidden input to store the selected folder -->
            <input type="hidden" id="selectedFolder" name="selectedFolder">
            
            <!-- File input for selecting the PDF -->
            <input type="file" name="fileToUpload" accept=".pdf" required>
            <input type="submit" value="Upload PDF" name="submit">
        </form>

        <!-- File Tree Section -->
        <h2>Select Folder to Save File</h2>
        <div id="fileTree">
            <!-- File tree generated from PHP -->
            <?php include 'file-tree.php'; ?>
        </div>

        <!-- JavaScript for File Tree Interaction -->
        <script>
        // Select all directory items and files
        const directories = document.querySelectorAll('.directory');
        const files = document.querySelectorAll('.file');

        directories.forEach(function(directory) {
            directory.addEventListener('click', function() {
                // Toggle selection for the current directory
                const wasSelected = directory.classList.toggle('selected');

                // Update the hidden input with the selected folder path
                const folderPath = directory.getAttribute('data-path');
                document.getElementById('selectedFolder').value = wasSelected ? folderPath : '';

                // Handle visibility of subfolders/files
                const subList = directory.nextElementSibling;
                if (subList) {
                    subList.style.display = wasSelected ? 'block' : 'none';
                }
            });

            // Toggle visibility of subfolders/files on double-click
            directory.addEventListener('dblclick', function() {
                directory.classList.toggle('open');
                const subList = directory.nextElementSibling;
                if (subList) {
                    subList.style.display = directory.classList.contains('open') ? 'block' : 'none';
                }
            });
        });

        files.forEach(function(file) {
            file.addEventListener('click', function(event) {
                // Deselect other files and highlight the clicked one
                files.forEach(f => f.classList.remove('selected'));
                file.classList.add('selected');
            });

            // Download functionality
            const downloadIcon = file.querySelector('.download-icon');
            downloadIcon.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent triggering file selection
                const filePath = file.getAttribute('data-path');
                window.location.href = 'dokumenti-download.php?file=' + encodeURIComponent(filePath);
            });

            // Add event listener for delete action
            const deleteIcon = file.querySelector('.delete-icon');
            deleteIcon.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent triggering file selection
                const confirmed = confirm('Are you sure you want to delete this file?');
                if (confirmed) {
                    const filePath = file.getAttribute('data-path');
                    window.location.href = 'dokumenti-delete.php?file=' + encodeURIComponent(filePath);
                }
            });
        });

        // Prevent form submission if no folder is selected
        document.querySelector('form').addEventListener('submit', function(event) {
            const selectedFolder = document.getElementById('selectedFolder').value;
            if (!selectedFolder) {
                alert('Please select a folder to upload the file.');
                event.preventDefault();
            }
        });
        </script>

    </div>
</body>
</html>

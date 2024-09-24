<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dokumenti</title>
</head>
<body>
    <div class="document-img">
        <img src="../assets/documents.png" height="256" width="256">
    </div>
    <article>
        <p>Skozi leta smo shranjevali rezultate, razpise in rekorde. Vse to in uradne dokumente ter razne ostale dokumente.</p>
        <p>Najdete jih spodaj.</p>

        <form action="dokumenti-upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload">
            <input type="submit" value="Upload PDF" name="submit">
        </form>

        <!-- File Tree Section -->
        <h2>File Tree</h2>
        <div id="fileTree"></div>

        <!-- Link to the external JavaScript file -->
        <script src="file-tree.js"></script>
    </article>
</body>
</html>
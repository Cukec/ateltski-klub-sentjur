<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files & Folders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

</head>
<body>
    <h2>Upload Files or Folders</h2>
    <form id="upload-form" method="POST" enctype="multipart/form-data">
        <input type="file" id="file-input" name="images[]" accept="image/*" multiple webkitdirectory>
        <button type="submit">Upload</button>
    </form>

    <script>
        document.getElementById("upload-form").addEventListener("submit", function(event) {
            event.preventDefault();
            
            const formData = new FormData();
            const files = document.getElementById("file-input").files;

            if (files.length === 0) {
                alert("Please select a folder to upload.");
                return;
            }

            // Extract folder name from first file
            const firstFilePath = files[0].webkitRelativePath;
            const folderName = firstFilePath.split("/")[0];  // Get the first folder

            formData.append("folderName", folderName); // Send folder name

            for (let file of files) {
                formData.append("images[]", file, file.webkitRelativePath);
            }

            fetch("resize-logic.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => alert(data))
            .catch(error => console.error("Error:", error));
        });
    </script>


<input type="text" id="archive-name" placeholder="Enter archive name">
<button id="upload-btn">Upload Files</button>
<form action="test.php" class="dropzone" id="file-dropzone"></form>

<script>
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone("#file-dropzone", {
    url: "test.php",
    paramName: "file",
    maxFilesize: 5, // MB
    acceptedFiles: "image/*",
    autoProcessQueue: false, // Prevents automatic upload
    parallelUploads: 10, // Allows up to 10 files at once
    init: function () {
        let dropzoneInstance = this;

        this.on("sending", function (file, xhr, formData) {
            let archiveName = document.getElementById("archive-name").value.trim();
            if (!archiveName) {
                alert("Please enter an archive name before uploading.");
                dropzoneInstance.removeFile(file);
                return;
            }
            formData.append("archive_name", archiveName);
        });

        document.getElementById("upload-btn").addEventListener("click", function () {
            if (dropzoneInstance.files.length === 0) {
                alert("Please add files before uploading.");
                return;
            }
            dropzoneInstance.processQueue(); // Manually process the queue
        });
    },
    
    transformFile: function(file, done) {
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(event) {
            var img = new Image();
            img.src = event.target.result;
            img.onload = function() {
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext("2d");

                // Determine new dimensions
                var width, height;
                if (img.width > img.height) {
                    width = 800;
                    height = 535;
                } else {
                    width = 535;
                    height = 800;
                }

                // Resize canvas
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                // Convert to blob and send to Dropzone
                canvas.toBlob(function(blob) {
                    let resizedFile = new File([blob], file.name, { type: file.type });
                    done(resizedFile);
                }, file.type);
            };
        };
    }
});


</script>



    
</body>
</html>

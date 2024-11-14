<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery Upload</title>
    <link rel="stylesheet" href="styles/galerija.css">
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.css">
</head>
<body>
    <?php include "navigation.php"; ?>

    <section class="galerija-info">
        <div class="description-main">
            <h1>Delo z atleti</h1>
            <hr>
            <p>V AK Šentjur stavimo veliko na delo z mladimi...</p>
        </div>
        <div class="img-galerija">
            <img src="../assets/camera.png" alt="" id="uploaded-image">
        </div>
        <!-- Button to open modal -->
        <button id="open-modal">Open Image Cropper</button>
    </section>

    <!-- Modal Structure -->
    <div id="cropper-modal">
        <div class="modal-content">
            <!-- Close Button -->
            <button id="close-modal">X</button>
            
            <!-- Aspect Ratio Selection -->
            <div class="aspect-ratio-options">
                <label><input type="radio" name="aspect-ratio" value="4/3" checked> 4:3</label>
                <label><input type="radio" name="aspect-ratio" value="3/4"> 3:4</label>
                <label><input type="radio" name="aspect-ratio" value="1/1"> 1:1</label>
            </div>
            
            <!-- Image to Crop -->
            <img id="image-to-crop" src="../assets/camera.png" alt="Image to crop">
            
            <!-- Button to Download Cropped Image -->
            <button id="download-cropped">Download Cropped Image</button>
        </div>
    </div>

    <!-- Cropper.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.js"></script>
    <script>
        let cropper;

        // Function to initialize the cropper with a specific aspect ratio
        function initializeCropper(aspectRatio) {
            const image = document.getElementById('image-to-crop');
            if (cropper) {
                cropper.destroy(); // Destroy previous cropper instance if exists
            }
            cropper = new Cropper(image, {
                aspectRatio: aspectRatio,
                viewMode: 1,
                autoCropArea: 0.65,
                responsive: true,
                minContainerHeight: 300,
                minContainerWidth: 400,
            });
        }

        // Initialize the cropper with default aspect ratio 4:3
        initializeCropper(4 / 3);

        // Change aspect ratio based on user selection
        document.querySelectorAll('input[name="aspect-ratio"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                const aspectRatio = this.value.split('/').map(Number);
                initializeCropper(aspectRatio[0] / aspectRatio[1]);
            });
        });

        // Open modal
        document.getElementById('open-modal').addEventListener('click', function() {
            document.getElementById('cropper-modal').style.display = 'flex';
        });

        // Close the modal
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('cropper-modal').style.display = 'none';
        });

        // Download the cropped image
        document.getElementById('download-cropped').addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas();
            const dataUrl = canvas.toDataURL('image/png');

            // Create a download link and trigger it
            const link = document.createElement('a');
            link.href = dataUrl;
            link.download = 'cropped-image.png';
            link.click();
        });
    </script>
</body>
</html>

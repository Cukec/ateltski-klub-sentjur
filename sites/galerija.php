<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery Upload</title>
    <link rel="stylesheet" href="styles/galerija.css">
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.css">

    <style>
        .wrking{
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 10vh;
            margin-top: -15vh;
        }
    </style>
</head>
<body>
    <?php include "navigation.php"; ?>

    <div class="wrking">
        <img src="../assets/working-on-it.png" height="35%" width="35%" alt="">
        <h1 style="color: gray">Delamo na tem!</h1>
    </div>
    

    <!--
    <section class="galerija-info">
        <div class="description-main">
            <h1>Delo z atleti</h1>
            <hr>
            <p>V AK Šentjur stavimo veliko na delo z mladimi...</p>
        </div>
        <div class="img-galerija">
            <img src="../assets/camera.png" alt="" id="uploaded-image">
        </div>
        
        <button id="open-modal">Open Image Cropper</button>
    </section>

    
    <div id="cropper-modal">
        <div class="modal-content">
            
            <button id="close-modal">X</button>
            
            
            <div class="aspect-ratio-options">
                <label><input type="radio" name="aspect-ratio" value="4/3" checked> 4:3</label>
                <label><input type="radio" name="aspect-ratio" value="3/4"> 3:4</label>
                <label><input type="radio" name="aspect-ratio" value="1/1"> 1:1</label>
            </div>
            
            
            <img id="image-to-crop" src="../assets/camera.png" alt="Image to crop">
            
           
            <button id="download-cropped">Download Cropped Image</button>
        </div>
    </div>

    
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
-->
    <?php include("footer.php") ?>
</body>
</html>

<?php
// CONFIG
$basePath = realpath(__DIR__ . '/../../../gallery/galerija');
$archiveName = $_GET['archive'] ?? '';

if (!$archiveName) {
    die("No archive specified.");
}

$archivePath = realpath($basePath . '/' . $archiveName);
if (!$archivePath || strpos($archivePath, $basePath) !== 0) {
    die("Invalid archive path.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['images'] as $originalName => $data) {
        $originalPath = $archivePath . '/' . $originalName;

        // Delete image
        if (!empty($data['delete']) && file_exists($originalPath)) {
            unlink($originalPath);
            continue;
        }

        // Rename image
        $newName = trim($data['name']);
        if ($newName && $newName !== $originalName) {
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $newNameWithExt = $newName . '.' . $extension;
            $newPath = $archivePath . '/' . $newNameWithExt;

            // Prevent overwrite
            if (!file_exists($newPath)) {
                rename($originalPath, $newPath);
                $originalPath = $newPath;
            }
        }

        // Rotate image
        $rotations = intval($data['rotate']);
        if ($rotations > 0 && file_exists($originalPath)) {
            $degrees = $rotations * 90;
            $source = imagecreatefromstring(file_get_contents($originalPath));
            $rotated = imagerotate($source, -$degrees, 0); // negative for clockwise
            imagejpeg($rotated, $originalPath, 90);
            imagedestroy($source);
            imagedestroy($rotated);
        }
    }
    echo "<p  class='alert-success'>Spremembe so shranjene!</p>";
}

// Load images
$images = glob($archivePath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Urejanje arhiva</title>
<link rel="stylesheet" href="styles/edit-archives.css">
<script>
function rotateImage(btn, imageName) {
    const img = btn.closest('.image-item').querySelector('img');
    let rotation = parseInt(btn.dataset.rotation || "0");
    rotation = (rotation + 90) % 360;
    btn.dataset.rotation = rotation;
    img.style.transform = `rotate(${rotation}deg)`;

    // Store number of 90° rotations in hidden field
    let rotateInput = document.querySelector(`input[name='images[${imageName}][rotate]']`);
    rotateInput.value = (parseInt(rotateInput.value) + 1) % 4;
}
</script>
</head>
<body>

<div class="title">
    <h2>Spreminjate vsebino <?php echo htmlspecialchars($archiveName); ?></h2>
    <a href="admin.php">⮨ nazaj</a>
</div>

<form method="post">

    <div class="toolbar" style="margin-bottom: 20px; text-align: right;">
        <button type="submit">💾 Shrani Spremembe</button>
    </div><br>
    <section class="images-container">
        <?php foreach ($images as $imgPath):
            $fileName = basename($imgPath);
            $nameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
        ?>
        <div class="image-item">
            <img src="<?php echo '../../../gallery/galerija/' . rawurlencode($archiveName) . '/' . rawurlencode($fileName); ?>" alt="">
            
            <div class="controls" style="justify-content: center;">
                <button type="button" onclick="rotateImage(this, '<?php echo htmlspecialchars($fileName); ?>')">🔄</button>
            </div>
            
            <input
                class="rename-input"
                type="text"
                name="images[<?php echo htmlspecialchars($fileName); ?>][name]"
                value="<?php echo htmlspecialchars($nameWithoutExt); ?>"
                placeholder="Preimenuj">

            <label class="delete-checkbox">
                <input type="checkbox" name="images[<?php echo htmlspecialchars($fileName); ?>][delete]" value="1">
                Izbriši
            </label>

            <input type="hidden" name="images[<?php echo htmlspecialchars($fileName); ?>][rotate]" value="0">
        </div>
        <?php endforeach; ?>
    </section>
    

</form>


</body>
</html>

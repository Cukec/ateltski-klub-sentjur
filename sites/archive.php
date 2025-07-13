<?php
$archiveName = isset($_GET['name']) ? basename($_GET['name']) : null;
if (!$archiveName) {
    die("Archive not specified.");
}

$archivePath = __DIR__ . "/../gallery/galerija/$archiveName";

include 'get_images_in_archive.php';
$images = getImageFiles($archivePath);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($archiveName) ?></title>
  <link rel="stylesheet" href="styles/archive.css">
</head>
<body>



<?php include("navigation.php") ?>
<main>
<div class="go-back">
    <a href="galerija.php">nazaj ↶</a>
</div>

<h1 style="text-align:center; padding-top: 2rem;"><?= htmlspecialchars($archiveName) ?></h1>

<div class="gallery" id="imageGallery">
  <?php foreach ($images as $i => $img): ?>
    <img src="../gallery/galerija/<?= $archiveName ?>/<?= $img ?>"
         data-index="<?= $i ?>"
         alt="<?= htmlspecialchars($img) ?>">
  <?php endforeach; ?>
</div>

<div class="modal" id="imageModal">
  <span class="arrow left" onclick="prevImage()">‹</span>
  <img id="modalImg" src="" alt="">
  <span class="arrow right" onclick="nextImage()">›</span>
  <span class="close" onclick="closeModal()">×</span>
</div>
</main>
<script>
  const images = Array.from(document.querySelectorAll('.gallery img'));
  const modal = document.getElementById('imageModal');
  const modalImg = document.getElementById('modalImg');
  let currentIndex = 0;

  images.forEach((img, index) => {
    img.addEventListener('click', () => {
      modal.classList.add('show');
      modalImg.src = img.src;
      currentIndex = index;
    });
  });

  function closeModal() {
    modal.classList.remove('show');
  }

  function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    modalImg.src = images[currentIndex].src;
  }

  function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    modalImg.src = images[currentIndex].src;
  }

  window.addEventListener('keydown', (e) => {
    if (!modal.classList.contains('show')) return;
    if (e.key === 'ArrowRight') nextImage();
    if (e.key === 'ArrowLeft') prevImage();
    if (e.key === 'Escape') closeModal();
  });
</script>

<?php include("footer.php") ?>

</body>
</html>

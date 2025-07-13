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
    <div id="archiveGallery"></div>
    <div id="pagination"></div>
</main>

<?php include("footer.php"); ?>

<script>
    function loadArchives(page = 1) {
  fetch(`archives_ajax.php?page=${page}`)
    .then(response => response.json())
    .then(data => {
      const container = document.getElementById('archiveGallery');
      container.innerHTML = '';

      // Create grid container
      const grid = document.createElement('div');
      grid.style.display = 'grid';
      grid.style.gridTemplateColumns = 'repeat(4, 1fr)';
      grid.style.gap = '1rem';

      data.archives.forEach(archive => {
        const item = document.createElement('div');
        item.style.cursor = 'pointer';

        item.innerHTML = `
          <img src="../gallery/galerija/${archive.lead_image}" alt="${archive.title}" class="archive-thumb">
          <p style="text-align:center; margin:0.5rem 0 0;">${archive.title}</p>
        `;

        item.addEventListener('click', () => {
          // Redirect to archive view page (customize the URL if needed)
          window.location.href = `archive.php?name=${encodeURIComponent(archive.title)}`;
        });

        grid.appendChild(item);
      });

      container.appendChild(grid);

      // Pagination
      const pagination = document.getElementById('pagination');
      pagination.innerHTML = '';

      for(let i = 1; i <= data.total_pages; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.style.margin = '0 0.3rem';
        if (i === data.current_page) {
          btn.disabled = true;
        }
        btn.addEventListener('click', () => loadArchives(i));
        pagination.appendChild(btn);
      }
    })
    .catch(err => {
      console.error('Failed to load archives', err);
    });
}

// Load first page initially
loadArchives();

</script>

</body>
</html>

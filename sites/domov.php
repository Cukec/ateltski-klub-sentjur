<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="styles/domov.css">

    <title>Domov</title>
</head>
<body>
    
    <?php include "navigation.php";  include "config.php"; ?>

    <main>
    <div class="section-title">
        <h1>Aktualno</h1>
    </div>
    <div class="main-grid">
        <div class="news-grid">
            <?php
            // Poizvedba
            $query = "SELECT id, title, content, id_image FROM news WHERE shown = 1 ORDER BY post_time DESC LIMIT 5;";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $title = htmlspecialchars($row['title']);
                    $content = strip_tags($row['content']); // odstrani HTML iz TinyMCE
                    $charLimit = ($i === 0) ? 500 : 100;

                    // Odrežemo na zadnji celi besedi
                    if (strlen($content) > $charLimit) {
                        $truncated = substr($content, 0, $charLimit);
                        $truncated = preg_replace('/\s+\S*$/', '', $truncated); // odreži do zadnje cele besede
                        $truncated .= '...';
                    } else {
                        $truncated = $content;
                    }

                    // Doda class "wide" samo prvi novici
                    $class = ($i === 0) ? "news-item wide" : "news-item";
                    ?>
                    <div class="<?= $class ?>">
                        <h3><?= $title ?></h3>
                        <hr>
                        <p><?= $truncated ?></p>
                        <a href="info-novica.php?id=<?= $id ?>">
                            <button class="read-more-btn">Preberi več</button>
                        </a>
                    </div>
                    <?php
                    $i++;
                }
            } else {
                echo '<div class="news-item wide"><p>Ni novic!</p></div>';
            }
            ?>
        </div>

        <?php
            $query = "SELECT * FROM links";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>

        <div class="sidebar">
            <div class="link-item"><a href="atleti.php"><img src="../assets/logo-atletska-sola.png" alt="atletska-šola"></a></div>
            <div class="link-item" id="itm-2">
                <h3>Uporabne povezave</h3>
                <ul>
                    <?php
                    
                    if($result->num_rows > 0){
                        while ($row = $result->fetch_assoc()){
                            
                            ?>
                            
                            <li><a href="<?php echo $row['url'] ?>"><?php echo $row['title'] ?></a></li>

                            <?php

                        }
                    }

                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="filler-grid">
        <div class="filler-item">
            <h3>TRENINGI</h3><br>
            <p>Oglejte si podrobnosti o lokacijah in terminih prihajajočih treningov</p><br>
            <a href="treningi.php">
                <button class="more-btn">Več o tem</button>
            </a>
        </div>
        <div class="filler-item">
            <div class="gallery-wrapper">
                <img src="" class="gallery-image"
                onerror="this.onerror=null; this.src='../assets/random-placeholder.jpg';">
            </div>
            <a href="galerija.php">
                <button class="more-btn">Galerija</button>
            </a>
        </div>
        <div class="filler-item">
            <h3>TEKMOVANJA</h3><br>
            <p>Oglejte si razpoložljive lokacije in pretekle ter prihajajoče termine tekmovanj, kjer se bodo preizkusili naši atleti</p><br>
            <a href="tekmovanja.php">
                <button class="more-btn">Več o tem</button>
            </a>
        </div>
    </div>

    <div class="section-title">
        <h1>Novice</h1>
    </div>

    <div class="past-grid" id="news-container">
    <!-- Tukaj se AJAX nalaga novice -->
    </div>

    <div class="pagination" id="pagination"></div>

</main>

    <?php include ('footer.php') ?>
</body>

<!-- skripta za naključno sliko -->
<script>
  function updateRandomImage() {
    fetch('random-image.php')
      .then(response => response.text())
      .then(imgPath => {
        const img = document.querySelector('.filler-item img');
        img.src = imgPath;
        img.width = 800;
        img.height = 535;
      })
      .catch(err => console.error('Napaka pri pridobivanju slike:', err));
  }

  // Prvi zagon
  updateRandomImage();

  // Nato vsake 10 sekund
  setInterval(updateRandomImage, 10000);
</script>

<!-- skripta za pagination -->
<script>
let currentPage = 1;
let totalPages = 1;

function loadNews(page = 1) {
  fetch(`pridobi-novice.php?page=${page}`)
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('news-container');
      container.innerHTML = '';

      data.news.forEach(item => {
        const div = document.createElement('div');
        div.className = 'news-item';
        div.innerHTML = `
          <h3>${item.title}</h3>
          <hr>
          <p>${item.content}</p>
          <a href="info-novica.php?id=${item.id}">
            <button class="read-more-btn">Preberi več</button>
          </a>`;
        container.appendChild(div);
      });

      totalPages = data.totalPages;
      renderPagination();
    });
}

function renderPagination() {
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  for (let i = 1; i <= totalPages; i++) {
    const btn = document.createElement('button');
    btn.innerText = i;
    btn.className = i === currentPage ? 'active' : '';
    btn.addEventListener('click', () => {
      currentPage = i;
      loadNews(i);
    });
    pagination.appendChild(btn);
  }
}

// Prvi zagon
document.addEventListener('DOMContentLoaded', () => {
  loadNews();
});

</script>

</html>

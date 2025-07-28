<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      background-color: #fff;
      overflow-x: hidden;
    }

    /* Main nav styling */
    nav {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80px;
      background-color: #FF9914;
      user-select: none;
    }

    nav a {
      color: white;
      padding: 0 20px;
      text-decoration: none;
      text-transform: uppercase;
      height: 80px;
      line-height: 80px;
      white-space: nowrap;
      position: relative;
      display: block;
    }

    nav #marker {
      position: absolute;
      height: 4px;
      width: 0;
      background: white;
      bottom: 0;
      transition: 0.5s;
      border-radius: 4px;
      z-index: 10;
    }

    /* Dropdown menu styling */
    nav .dropdown {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    nav .dropdown:hover .submenu {
      display: flex;
    }

    nav .submenu {
      display: none;
      position: absolute;
      top: 80px;
      left: 0;
      background-color: #FF9914;
      flex-direction: column;
      min-width: 160px;
      z-index: 100;
    }

    nav .submenu a {
      padding: 10px 20px;
      line-height: 1.2;
      height: auto;
      color: white;
      text-transform: none;
      border-top: 1px solid rgba(255,255,255,0.1);
    }

    nav .submenu a:hover {
      background-color: #e2810f;
    }

    /* ----------- BURGER MENU STUFF ----------- */
    /* Burger icon container */
    .burger {
      display: none; /* skrito na desktop */
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      width: 30px;
      height: 25px;
      cursor: pointer;
      z-index: 200;
      flex-direction: column;
      justify-content: space-between;
    }

    /* Burger bars */
    .burger div {
      width: 100%;
      height: 4px;
      background-color: white;  
      border-radius: 2px;
      transition: all 0.3s ease;
    }

    /* Nav items container for mobile */
    nav .nav-items {
      position: relative;
      display: flex;
      gap: 20px;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
      nav {
        justify-content: flex-start;
        padding-left: 20px;
      }

      /* Skrij originalne nav-item, uporabimo nav-items kot container */
      nav .nav-items {
        position: fixed;
        top: 80px;
        left: 0;
        width: 100%;
        height: calc(100% - 80px);
        background-color: #FF9914;
        flex-direction: column;
        align-items: start;
        padding: 20px;
        gap: 10px;
        overflow-y: auto;

        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 150;
      }

      /* Ko je menu odprt */
      nav .nav-items.active {
        transform: translateX(0);
      }

      nav .nav-item {
        width: 100%;
      }

      nav a {
        padding: 15px 10px;
        height: auto;
        line-height: normal;
      }

      nav .dropdown:hover .submenu {
        display: none; /* on mobile hover ne deluje */
      }

      /* Submenu default: skrito */
      nav .submenu {
        position: relative;
        top: 0;
        left: 0;
        background-color: #e2810f;
        min-width: 100%;
        flex-direction: column;
        border-radius: 0 0 4px 4px;
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.3s ease;
      }

      nav .submenu.active {
        max-height: 500px; /* dovolj visoko da se pokaže */
      }

      nav .submenu a {
        border-top: none;
        padding-left: 30px;
      }

      /* Burger prikaz */
      .burger {
        display: flex;
        left: 20px;
      }
    }
  </style>
</head>
<body>

<nav>
  

  <!-- burger ikonca -->
  <div class="burger" id="burger">
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- ovo wrapam v container, da lahko na mobilu upravljam cel meni -->
  <div class="nav-items">
    <div id="marker"></div>
    <div class="nav-item">
      <a href="domov.php">domov</a>
    </div>

    <div class="nav-item">
      <a href="treningi.php">treningi</a>
    </div>

    <div class="nav-item dropdown">
      <a href="dogodki.php" class="dropdown-toggle">dogodki</a>
      <div class="submenu">
        <a href="dogodki.php#future-events-container">prihajajoči</a>
        <a href="dogodki.php#pretekli">pretekli</a>
      </div>
    </div>

    <div class="nav-item dropdown">
      <a href="atleti.php" class="dropdown-toggle">atleti</a>
      <div class="submenu">
        <a href="atleti.php">aktivni</a>
        <a href="atleti.php">nekdanji</a>
        <a href="tablice-atleti.php">tablice</a>
      </div>
    </div>

    <div class="nav-item">
      <a href="dosezki.php">dosežki</a>
    </div>

    <div class="nav-item dropdown">
      <a href="nasa-ekipa.php" class="dropdown-toggle">naša ekipa</a>
      <div class="submenu">
        <a href="nasa-ekipa.php#vodstvo">vodstvo</a>
        <a href="nasa-ekipa.php#trenerji">trenerji</a>
        <a href="nasa-ekipa.php#sodniki">sodniki</a>
      </div>
    </div>

    <div class="nav-item dropdown">
      <a href="o-klubu.php" class="dropdown-toggle">o klubu</a>
      <div class="submenu">
        <a href="o-klubu.php#predstavitev">predstavitev</a>
        <a href="o-klubu.php#predstavitev">zgodovina</a>
        <a href="o-klubu.php#dokumenti">dokumenti</a>
        <a href="o-klubu.php#kakoDoNas">kako do nas</a>
      </div>
    </div>

    <div class="nav-item">
      <a href="galerija.php">galerija</a>
    </div>
  </div>
</nav>

<img src="../assets/aks-glava-2.svg" alt="" width="100%" />

<script>
  const marker = document.querySelector('#marker');
  const navItems = document.querySelectorAll('nav .nav-item');
  const burger = document.getElementById('burger');
  const navItemsContainer = document.querySelector('nav .nav-items');
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

  // Map submenu pages to their parent top-level page
  const submenuMap = {
    'atleti.php': 'atleti.php',
    'tablice-atleti.php': 'atleti.php',

    'vodstvo.php': 'nasa-ekipa.php',
    'trenerji.php': 'nasa-ekipa.php',
    'sodniki.php': 'nasa-ekipa.php',

    'predstavitev.php': 'o-klubu.php',
    'zgodovina.php': 'o-klubu.php',
    'dokumenti.php': 'o-klubu.php',
    'kako-do-nas.php': 'o-klubu.php',

    'prihajajoci.php': 'dogodki.php',
    'pretekli.php': 'dogodki.php'
  };

  let activeIndex = 0;
  

  function moveMarkerToNavItem(navItem) {
    const rect = navItem.getBoundingClientRect();
    const containerRect = navItemsContainer.getBoundingClientRect();

    const left = rect.left - containerRect.left + navItemsContainer.scrollLeft;

    marker.style.left = left + "px";
    marker.style.width = rect.width + "px";
  }



  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
      navItemsContainer.classList.remove('active');
      moveMarkerToNavItem(navItems[activeIndex]);
    } else {
      marker.style.width = "0";
      marker.style.left = "0";
    }
  });


  function setActiveByUrl() {
    const currentPage = window.location.pathname.split('/').pop();

    const pageToMatch = submenuMap[currentPage] || currentPage;

    navItems.forEach((navItem, index) => {
      const link = navItem.querySelector('a');
      if (link && link.getAttribute('href') === pageToMatch) {
        activeIndex = index;
      }
    });

    moveMarkerToNavItem(navItems[activeIndex]);
  }

  navItems.forEach((navItem, index) => {
    const link = navItem.querySelector('a');
    if (!link) return;

    link.addEventListener('mouseenter', () => {
      moveMarkerToNavItem(navItem);
    });

    link.addEventListener('click', () => {
      activeIndex = index;
      moveMarkerToNavItem(navItems[activeIndex]);
    });
  });

  document.querySelector('nav').addEventListener('mouseleave', setActiveByUrl);

  window.onload = () => {
    marker.style.transition = "none";
    setTimeout(() => {
      marker.style.transition = "0.5s";
    }, 10);
    setActiveByUrl();
  };

  // --- BURGER MENU JS ---

  burger.addEventListener('click', () => {
    navItemsContainer.classList.toggle('active');
  });

  // Za mobilne dropdown menije: toggle submenu on click on the parent link
  dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', (e) => {
      if(window.innerWidth > 768) return; // samo na mobilnih

      e.preventDefault(); // prepreči navigacijo

      const submenu = toggle.nextElementSibling;
      if (!submenu) return;

      submenu.classList.toggle('active');
    });
  });

  // Ob resize skrij meni in marker nastavi na desktop pravilno
  window.addEventListener('resize', () => {
    if(window.innerWidth > 768) {
      navItemsContainer.classList.remove('active');
      moveMarkerToNavItem(navItems[activeIndex]);
    } else {
      marker.style.width = 0;
    }
  });
</script>

</body>
</html>

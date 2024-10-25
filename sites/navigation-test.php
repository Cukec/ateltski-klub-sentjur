<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fff;
    overflow-x: hidden;
}

/* Main nav styling */
nav {
    display: flex;
    justify-content: center;
    height: 80px;
    background-color: #FF9914;
    box-shadow: rgba(0, 0, 0, 0.5) 0px 4px 15px;
    z-index: 999;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    height: 100%;
    align-items: center;
    flex-wrap: nowrap;
}

nav ul li {
    position: relative;
    white-space: nowrap;
}

nav ul li a {
    display: block;
    color: white;
    text-align: center;
    padding: 0 20px;
    text-decoration: none;
    text-transform: uppercase;
    height: 80px;
    line-height: 80px;
    white-space: nowrap;
    position: relative;
}

/* Hamburger menu icon */
.hamburger {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    width: 40px;
    height: 40px;
}

.hamburger div {
    width: 30px;
    height: 3px;
    background-color: white;
    margin: 5px 0;
    transition: 0.4s;
}

/* Toggle class for the menu */
nav ul.active {
    display: flex;
    flex-direction: column;
    position: absolute;
    top: 80px;
    left: 0;
    width: 100%;
    background-color: #FF9914;
}

nav ul li {
    width: 100%;
    text-align: center;
}

/* Responsive for iPads and phones */
@media (max-width: 768px) {
    nav ul {
        display: none; /* Hide nav links by default */
        flex-direction: column;
    }

    nav {
        justify-content: space-between;
        padding: 0 20px;
    }

    .hamburger {
        display: flex;
    }

    nav ul li {
        width: 100%;
        text-align: center;
    }

    nav ul li a:hover{
    background-color: #cc7a0b;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: background-color 1s ease, box-shadow 1s ease;
}

    .dropdown-content {
        position: static; /* Make dropdowns part of the flow */
        width: 100%;
        border-radius: 0;
    }

    nav ul.active {
        display: flex; /* Show nav links when active */
    }
}

/* Animation for hamburger icon when clicked (cross effect) */
.change .bar1 {
    transform: rotate(-45deg) translate(-6px, 6px);
}

.change .bar2 {
    opacity: 0;
}

.change .bar3 {
    transform: rotate(45deg) translate(-6px, -6px);
}

    </style>
</head>
<body>

    <nav>
        <!-- Hamburger menu icon -->
        <div class="hamburger" onclick="toggleMenu()">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>

        <ul>
            <li><a href="domov.php">domov</a></li>
            <li><a href="treningi.php">treningi</a></li>
            <li><a href="tekmovanja.php">tekmovanja</a></li>
            <li> <!-- class dropdown -->
                <a href="atleti.php">atleti</a>
                <!--
                <div class="dropdown-content">
                    <a href="atleti-aktivni.php">aktivni</a>
                    <a href="atleti-nekdanji.php">nekdanji</a>
                    <a class="zadnji" href="#">dosežki</a>
                </div>
                -->
            </li>
            <li> <!-- class dropdown -->
                <a href="nasa-ekipa.php">naša ekipa</a>
                <!--
                <div class="dropdown-content">
                    <a href="trenerji.php">trenerji</a>
                    <a href="vodstvo.php">vodstvo</a>
                    <a class="zadnji" href="sodniki.php">sodniki</a>
                </div>
                -->
            </li>
            <li> <!-- class dropdown -->
                <a href="o-klubu.php">o klubu</a>
                <!--
                <div class="dropdown-content">
                    <a href="predstavitev.php">predstavitev</a>
                    <a href="dokumenti.php">dokumenti</a>
                    <a class="zadnji" href="#">kako do nas</a>
                </div>
                -->
            </li>
            <li><a href="galerija.php">galerija</a></li>
        </ul>
    </nav>

    <img src="../assets/aks-glava-2.svg" alt="" width="100%">

    <script>
        // Toggle the main menu (hamburger)
        function toggleMenu() {
            var nav = document.querySelector("nav ul");
            var hamburger = document.querySelector(".hamburger");
            var body = document.querySelector("body");

            nav.classList.toggle("active");
            hamburger.classList.toggle("change");

            // Disable scrolling when menu is active
            if (nav.classList.contains("active")) {
                body.style.overflow = "hidden";
            } else {
                body.style.overflow = "auto";
            }
        }

        // Toggle dropdown on click for mobile devices
        function toggleDropdown(event) {
            event.preventDefault();
            var dropdown = event.target.nextElementSibling;
            dropdown.classList.toggle("active");
        }

        // Close menu on window resize if menu is open and screen is enlarged
        window.addEventListener('resize', function () {
            var nav = document.querySelector("nav ul");
            var hamburger = document.querySelector(".hamburger");
            var body = document.querySelector("body");

            // Close the menu if the window width is greater than 768px and the menu is open
            if (window.innerWidth > 768 && nav.classList.contains("active")) {
                nav.classList.remove("active");
                hamburger.classList.remove("change");
                body.style.overflow = "auto"; // Re-enable scrolling
            }
        });
    </script>

</body>
</html>
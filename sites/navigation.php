<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    height: 80px;
    background-color: #FF9914;
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
}

nav #marker {
    position: absolute;
    height: 4px;
    width: 0;
    background: white;
    bottom: 0;
    transition: 0.5s;
    border-radius: 4px;
}

    </style>
</head>
<body>

    <nav>
        <div id="marker"></div>
        <a href="domov.php">domov</a>
        <a href="treningi.php">treningi</a>
        <a href="dogodki.php">dogodki</a>
        <a href="atleti.php">atleti</a>
        <a href="nasa-ekipa.php">naša ekipa</a>
        <a href="o-klubu.php">o klubu</a>
        <a href="galerija.php">galerija</a>
    </nav>

    <img src="../assets/aks-glava-2.svg" alt="" width="100%">


    <script>
        var marker = document.querySelector('#marker');
        var items = document.querySelectorAll('nav a');
        var activeIndex = 0;

        function indicator(e) {
            marker.style.left = e.offsetLeft+"px";
            marker.style.width = e.offsetWidth+"px";
        }

        function setMarkerToActive() {
            var activeLink = items[activeIndex];
            indicator(activeLink);
        }

        function setActiveLink() {
            const currentPath = window.location.pathname.split('/').pop();
            const altPath = window.location.pathname.split('-').pop();
            items.forEach((link, index) => {
                if (link.getAttribute('href') === currentPath) {
                    activeIndex = index;
                }
                else if (link.getAttribute('href') === altPath) {
                    activeIndex = index;
                }
            })
            setMarkerToActive();
        }

        items.forEach((link, index) => {
            link.addEventListener('mouseenter', (e)=>{
                indicator(e.target);
            })

            link.addEventListener('click', (e) => {
                activeIndex = index;
                setMarkerToActive();
            })
        })

        document.querySelector('nav').addEventListener('mouseleave', setMarkerToActive);
        window.onload = () => {
            marker.style.transition = "none";
            setTimeout(() => {
                marker.style.transition = "0.5s";
            }, 10)
            setActiveLink();
        };
    </script>
</body>
</html>

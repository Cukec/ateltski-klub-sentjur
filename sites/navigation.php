<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background-color: #ececec;
}


nav {
    height: 80px;
    background-color: #f94449;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

@font-face {
    font-family: "MadeCarving";
    src: url('MADECarvingSoftOutlinePERSONALUSE-Black.otf') format('opentype');
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    background-color: #f94449;
    padding-left: 100px;
    height: 100%; /* Ensure ul fills the nav */
}

nav ul li {
    float: left;
    margin-top: 0; /* Remove margin for alignment */
    position: relative; /* Important for dropdown positioning */
    height: 100%; /* Ensure li fills the nav */
}

nav ul li a {
    display: block;
    color: white;
    text-align: center;
    padding: 0 20px 0 20px;
    text-decoration: none;
    text-transform: uppercase;
    box-sizing: border-box;
    height: 80px; /* Match the height of the nav */
    line-height: 80px; /* Center text vertically */
    margin-bottom: 5px;
}

nav ul li a:hover {
    border-bottom: 4px solid #ffffff;
}

/* Dropdown menu */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 160px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1;
    top: 100%;
    left: 0;
    margin-top: 0;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.dropdown:hover .dropdown-content {
    display: block;
}

nav ul li img {
    padding-top: 10%;
    height: 80%;
    width: 85%;
    filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.5));
}

.1{
    margin-left: 5vw;
}


    </style>

</head>
<body>
    <nav>
        <ul>
        <!-- Logo -
        <li><img src="../assets/aksentjur-logo.png" alt=""></li>
        -->

        <li><p style="font-weight: bold; color: white; font-size: 2.5vh;">AK ŠENTJUR</p></li>
        <li style="margin-left: 1%; color: #f5f5f5"><p style="font-size: 2.5vh;">|</p></li>

        <li class="1"><a href="domov.php">domov</a></li>
        <li><a href="tekmovanja.php">tekmovanja</a></li>

        <!-- Atleti with Dropdown -->
        <li class="dropdown">
            <a href="#">atleti</a>
            <div class="dropdown-content">
                <a href="atleti-aktivni.php">aktivni</a>
                <a href="atleti-nekdanji.php">nekdanji</a>
                <a href="#">dosežki</a>
            </div>
        </li>

        <!-- Naša Ekipa with Dropdown -->
        <li class="dropdown">
            <a href="#">naša ekipa</a>
            <div class="dropdown-content">
                <a href="trenerji.php">trenerji</a>
                <a href="vodstvo.php">vodstvo</a>
                <a href="sodniki.php">sodniki</a>
            </div>
        </li>

        <!-- O Klubu with Dropdown -->
            <li class="dropdown">
                <a href="#">o klubu</a>
                <div class="dropdown-content">
                    <a href="predstavitev.php">predstavitev</a>
                    <a href="dokumenti.php">dokumenti</a>
                    <a href="finance.php">finance</a>
                </div>
            </li>

            <li><a href="galerija.php">galerija</a></li>
        </ul>
    </nav>
</body>
</html>

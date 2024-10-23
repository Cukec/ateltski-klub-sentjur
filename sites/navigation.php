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
}


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
    padding: 0 20px;
    text-decoration: none;
    text-transform: uppercase;
    box-sizing: border-box;
    height: 80px; /* Match the height of the nav */
    line-height: 80px; /* Center text vertically */
}

nav ul li a:hover, .dropdown-content a:hover{
    background-color: #cc7a0b;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: background-color 1s ease, box-shadow 1s ease;
}

nav ul li:hover .dropdown-content{
    display: block;
    opacity: 1; /* Fully visible */
    transform: translateY(0); /* Back to its normal position */
    pointer-events: auto;
}

/* Dropdown menu */
.dropdown-content {
    display: block;
    position: absolute;
    background-color: #FF9914;
    width: auto;
    min-width: 100%;
    z-index: 1;
    top: 100%;
    left: 0;
    margin-top: 0;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    
    opacity: 0; /* Start with invisible */
    transform: translateY(-40px); /* Start 20px higher */
    transition: opacity 0.3s ease, transform 0.3s ease; /* Smooth transition */
    pointer-events: none;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: white;
    padding: 0px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
    height: 50px;
    line-height: 50px;
}

.dropdown-content a.zadnji {
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}

nav ul li img {
    padding-top: 10%;
    height: 80%;
    width: 85%;
    filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.5));
}


    </style>

</head>
<body>
    <nav>
        <ul>
        <!-- Logo -
        <li><img src="../assets/aksentjur-logo.png" alt=""></li>
        -->

        <!-- <li><p style="font-weight: bold; color: white; font-size: 2.5vh;">AK ŠENTJUR</p></li>
        <li style="margin-left: 1%; color: #f5f5f5"><p style="font-size: 2.5vh;">|</p></li> -->
        <li><a href="domov.php">domov</a></li>
        <li><a href="treningi.php">treningi</a></li>
        <li><a href="tekmovanja.php">tekmovanja</a></li>

        <!-- Atleti with Dropdown -->
        <li class="dropdown">
            <a href="#">&#11167; atleti</a>
            <div class="dropdown-content">
                <a href="atleti-aktivni.php">aktivni</a>
                <a href="atleti-nekdanji.php">nekdanji</a>
                <a class="zadnji" href="#">dosežki</a>
            </div>
        </li>

        <!-- Naša Ekipa with Dropdown -->
        <li class="dropdown">
            <a href="#">&#11167; naša ekipa</a>
            <div class="dropdown-content">
                <a href="trenerji.php">trenerji</a>
                <a href="vodstvo.php">vodstvo</a>
                <a class="zadnji" href="sodniki.php">sodniki</a>
            </div>
        </li>

        <!-- O Klubu with Dropdown -->
            <li class="dropdown">
                <a href="#">&#11167; o klubu</a>
                <div class="dropdown-content">
                    <a href="predstavitev.php">predstavitev</a>
                    <a href="dokumenti.php">dokumenti</a>
                    <a class="zadnji" href="#">kako do nas</a>
                </div>
            </li>

            <li><a href="#">galerija</a></li>
        </ul>
    </nav>
    <img src="../assets/aks-glava-2.svg" alt="" width="100%">
</body>
</html>

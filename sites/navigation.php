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
    background-color: #ececec;
}


nav {
    display: flex;
    height: 80px;
    background: linear-gradient(0deg, #ba1010 0%, #e95e5e 100%);
    box-shadow: rgba(0, 0, 0, 0.5) 0px 4px 15px;
    z-index: 999;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
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
    padding: 0 20px;
    text-decoration: none;
    text-transform: uppercase;
    box-sizing: border-box;
    height: 80px; /* Match the height of the nav */
    line-height: 80px; /* Center text vertically */
    position: relative; /* Needed for the pseudo-element */
}

nav ul .border a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 4px;
    background-color: white;
    transition: width 0.3s ease, left 0.3s ease;
}

nav ul .border:hover a::after {
    width: 100%; /* Expands to the full width of the dropdown */
    left: 0;
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
    background-color: white;
    width: auto;
    min-width: 100%;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1;
    top: 100%;
    left: 0;
    margin-top: 0;
    
    opacity: 0; /* Start with invisible */
    transform: translateY(-20px); /* Start 20px higher */
    transition: opacity 0.3s ease, transform 0.3s ease; /* Smooth transition */
    pointer-events: none;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 0px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
    height: 50px;
    line-height: 50px;
}

.dropdown-content a:hover {
    background-color: #bcbfbb;
}
.dropdown-submenu {
    display: none; /* Hide submenu by default */
    position: absolute;
    left: 100%; /* Position it to the right of the parent dropdown */
    top: 0;
    background-color: white;
    z-index: 1;
    min-width: 100%; /* Adjust as needed */
}

.dropdown-content a:hover + .dropdown-submenu {
    display: block; /* Show submenu on hover */
}

.dropdown-submenu:hover{
    display: block; /* Show submenu when hovering over the dropdown */
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
        <img src="../assets/aksentjur-logo.png" alt="logo">
        <ul>
        <!-- Logo -
        <li><img src="../assets/aksentjur-logo.png" alt=""></li>
        -->

        <!-- <li><p style="font-weight: bold; color: white; font-size: 2.5vh;">AK ŠENTJUR</p></li>
        <li style="margin-left: 1%; color: #f5f5f5"><p style="font-size: 2.5vh;">|</p></li> -->
        <li class="border"><a href="domov.php">domov</a></li>
        <li class="border"><a href="tekmovanja.php">dogodki</a></li>

        <!-- Atleti with Dropdown -->
        <li class="dropdown">
            <a href="#">&#11167; atleti</a>
            <div class="dropdown-content">
                <a href="atleti-aktivni.php">aktivni</a>
                <a href="atleti-nekdanji.php">nekdanji</a>
                <a href="#">dosežki</a>
            </div>
        </li>

        <!-- Naša Ekipa with Dropdown -->
        <li class="dropdown">
            <a href="#">&#11167; naša ekipa</a>
            <div class="dropdown-content">
                <a href="trenerji.php">&#11166; trenerji &#11166;</a>
                <div class="dropdown-submenu">
                    <a href="treningi.php">treningi</a>
                    <a href="#">kako do nas</a>
                </div>
                <a href="vodstvo.php">vodstvo</a>
                <a href="sodniki.php">sodniki</a>
            </div>
        </li>

        <!-- O Klubu with Dropdown -->
            <li class="dropdown">
                <a href="#">&#11167; o klubu</a>
                <div class="dropdown-content">
                    <a href="predstavitev.php">predstavitev</a>
                    <a href="dokumenti.php">dokumenti</a>
                </div>
            </li>

            <li class="border"><a href="galerija.php">galerija</a></li>
        </ul>
    </nav>
</body>
</html>

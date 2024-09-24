<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: "MadeCarving";
            margin: 0;
            background-color: #ececec;
        }

        nav {
            height: 80px;
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            margin-top: 50px;
        }

        @font-face {
            font-family: "MadeCarving";
            src: url('MADECarvingSoftOutlinePERSONALUSE-Black.otf') format('opentype');
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #333;
            padding-left: 100px;
        }

        nav ul li {
            float: left;
            margin-top: 7px;
            position: relative; /* Important for dropdown positioning */
        }

        nav ul li a {
            display: block;
            color: #444; /* Ensure text is white and visible */
            text-align: center;
            padding: 20px 25px; /* Adjust padding as necessary */
            text-decoration: none;
            text-transform: uppercase;
            box-sizing: border-box; /* Ensure padding is included in width */
        }

        /* Hover effect for main items */
        nav ul li a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Dropdown menu */
        .dropdown-content {
            display: none; /* Hidden by default */
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            
            z-index: 1;
            top: 100%; /* Place dropdown directly below the menu */
            left: 0; /* Align dropdown with the parent item */
            margin-top: 0; /* Remove margin if necessary */
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

        .dropdown:hover .dropdown-content{
            display: block;
        }

    </style>

</head>
<body>
    <nav>
        <ul>
        <li><a href="#">domov</a></li>
        <li><a href="#">tekmovanja</a></li>

        <!-- Atleti with Dropdown -->
        <li class="dropdown">
            <a href="#">atleti</a>
            <div class="dropdown-content">
                <a href="#">aktivni</a>
                <a href="#">nekdanji</a>
                <a href="#">dosežki</a>
            </div>
        </li>

        <!-- Naša Ekipa with Dropdown -->
        <li class="dropdown">
            <a href="#">naša ekipa</a>
            <div class="dropdown-content">
                <a href="#">trenerji</a>
                <a href="#">vodstvo</a>
                <a href="#">sodniki</a>
            </div>
        </li>

        <!-- O Klubu with Dropdown -->
            <li class="dropdown">
                <a href="#">o klubu</a>
                <div class="dropdown-content">
                    <a href="#">predstavitev</a>
                    <a href="#">dokumenti</a>
                    <a href="#">finance</a>
                </div>
            </li>

            <li><a href="#">galerija</a></li>
        </ul>
    </nav>
</body>
</html>

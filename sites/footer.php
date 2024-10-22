<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="styles/footer.css"> -->
    <style>
        footer {
            background-color: #f1f1f1; /* Light gray background for contrast */
            display: flex;
            padding: 2vh;
            justify-content: space-between;
            flex-wrap: wrap;
            border-top: 2px solid gray;
        }

        footer h3 {
            color: gray;
            margin-bottom: 10px;
        }

        footer p {
            color: gray;
            margin: 5px 0;
        }

        .kontakt, .sponsor, .finance {
            text-align: center;
            flex: 1;
        }

        .sponsor {
            padding-top: 3vh;
            display: flex;
            justify-content: center;
            gap: 2vw;
        }

        .sponsor img {
            max-width: 100%;
            max-height: 10vw;
        }

        /* Responsive styling for smaller screens */
        @media (max-width: 768px) {
            footer {
                flex-direction: column;
                align-items: center;
            }
            .sponsor {
                justify-content: center;
            }
        }
    </style>
</head>
    <footer>
        <div class="kontakt">
            <h3>Atletski klub Šentjur</h3>
            <p>Cesta Miloša Zidanška 28</p>
            <p>3230 Šentjur</p>
            <h3>Kontakti</h3>
            <p>Vladimir Artnak</p>
            <p>&#9742; +386 (0)31 826 969</p>
            <p>info@aksentjur.si</p>
        </div>
        <div class="sponsor">
            <img src="../assets/obcina-sentjur.jpg" alt="obcina-sentjur-logo">
            <img src="../assets/asfalt-kovac.jpg" alt="asfalt-kovac-logo">
        </div>
        <div class="finance">
            <h3 id="fin">Finance</h3>
            <p>Davčna Številka: 85867730</p>
            <p>(nismo davčni zavezanci)</p>
            <p>TRR: SI56 0400 1004 7338 026</p>
            <p>Banka: NKBM</p>
            <h3>Ostalo</h3>
            <p>Vpisani v register društev pri UE Šentjur.<br>AKŠ ima z odločbo 6717-166/2019/2<br>(081-06) status nevladne organizacije<br>v javnem interesu na področju športa</p>
        </div>
    </footer>
</html>
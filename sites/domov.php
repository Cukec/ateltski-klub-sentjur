<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/domov.css">

    <title>Domov</title>
</head>
<body>
    
    <?php include "navigation.php"; ?>

    <!-- Main content container -->
    <div class="main-content">
        <div class="container">
            <!-- Rotacija slik (Image Rotation) -->
            <div class="img-rotation">
                <img src="blank.jpg" alt="Blank Image" class="rotation-img">
            </div>

            <!-- Dogodki (Events) -->
            <div class="dogodki">
                <div class="dogodek">
                    <h2>Dogodek 1</h2>
                    <p>Opis dogodka 1: Tukaj je opis prvega dogodka.</p>
                </div>
                <div class="dogodek">
                    <h2>Dogodek 2</h2>
                    <p>Opis dogodka 2: Tukaj je opis drugega dogodka.</p>
                </div>
                <div class="dogodek">
                    <h2>Dogodek 3</h2>
                    <p>Opis dogodka 3: Tukaj je opis tretjega dogodka.</p>
                </div>
            </div>
        </div>

        <!-- Novice (News) -->
        <div class="novice">
            <div class="novica">
                <h2>Novica 1</h2>
                <p>Opis novice 1: Tukaj je opis prve novice.</p>
            </div>
            <div class="novica">
                <h2>Novica 2</h2>
                <p>Opis novice 2: Tukaj je opis druge novice.</p>
            </div>
            <div class="novica">
                <h2>Novica 3</h2>
                <p>Opis novice 3: Tukaj je opis tretje novice.</p>
            </div>
        </div>
    </div>

</body>
</html>

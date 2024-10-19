<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/trenerji-vodstvo.css">
    <title>Nekdanji atleti</title>
</head>
<body>

    <?php include "navigation.php"; ?>
    
    <?php 
    $profiles = [
        ['name' => 'Vladimir', 'surname' => 'Artnak', 'email' => '', 'roles' => 'trener'],
        ['name' => 'Cmok', 'surname' => 'Luka', 'email' => '', 'roles' => 'trener'],
        ['name' => 'Katja', 'surname' => 'Jevšnik', 'email' => '', 'roles' => 'trenerka'],
        ['name' => 'Ivan', 'surname' => 'Kukovič', 'email' => '', 'roles' => 'trener'],
        ['name' => 'Rok', 'surname' => 'Novak', 'email' => '', 'roles' => 'trener'],
        ['name' => 'Bojan', 'surname' => 'Očko', 'email' => '', 'roles' => 'trener'],
        ['name' => 'Borut', 'surname' => 'Pihlar', 'email' => '', 'roles' => 'trener'],
        ['name' => 'Andrej', 'surname' => 'Podgoršek', 'email' => '', 'roles' => 'trener'],
        ['name' => 'Robert', 'surname' => 'Švegler', 'email' => '', 'roles' => 'trener'],
    ];
    ?>

    <div class="custom-shape">
        <div class="left-text">
            <h2>nekdanji atleti</h2>
        </div>
        <div class="vertical-line"></div>
        <div class="right-text">
            <p>

                Skozi leta smo pri nas trenirali mnogo otrok, čeprav nekateri niso več del našega kluba jih lahko navedene najdete spodaj
            </p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const shape = document.querySelector('.custom-shape');
            shape.classList.add('slide-in');
        });
    </script>

    <div class="content">
    <section class="profile-container">

        <?php
        foreach ($profiles as $profile) {
            echo '
            <div class="profile-card">
                <div class="empty-pfp">?</div>
                <div class="profile-info">
                    <h2>' . $profile['name'] . '</h2>
                    <h3>' . $profile['surname'] . '</h3>
                    <p class="email">' . $profile['email'] . '</p>
                    <p class="roles">' . $profile['roles'] . '</p>
                </div>
            </div>';
        }
        ?>

    </section>
    </div>
    <?php include"footer.php"; ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/trenerji-vodstvo.css">
    <title>AK Sentjure - Nasa Ekipa</title>
</head>
<body>
    <?php include "navigation.php";  include "config.php"; ?>
    <main>
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
        
        <section class="atleti-info">
            <div class="description-main">
                <h1>Vodstvo, trenerji in sodniki</h1>
                <hr>
                <p>Atletski klub je zavezan spodbujanju športnega duha, timskega dela in osebne rasti vseh svojih članov. Vodstvo kluba sestavljajo trenerji in strokovnjaki navdušeni nad atletiko.</p>
            </div>
            <div class="atletska-sola">
                <a href="treningi.php"><img src="../assets/logo-atletska-sola.png" alt="logo-atletska-sola"></a>
            </div>
        </section>

        <div class="nav-dogodki" id="past-events-section">
            <ul>
                <li><p>Vodstvo</p></li>
                <li><p>Trenerji</p></li>
                <li><p>Sodniki</p></li>
            </ul>
        </div>

        <div class="vodstvo">
            <div class="naslov-vodstvo">
                <h2>VODSTVO</h2>
                <p>
                    Vodstvo atletskega kluba Šentjur, ki ga sestavljajo trenerji in strokovnjaki navdušeni nad atletiko
                </p>
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
        </div>

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

        <div class="trenerji">
            <div class="naslov-trenerji">
                <h2>TRENERJI</h2>
                <p>
                Pri delu stavimo na usposobljen doma vzgojen trenerski kader z ustrezno izobrazbo ali usposobljenostjo in trenersko licenco. Trenutno aktivni trenerji so
                </p>
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
        </div>

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

        <div class="sodniki">
            <div class="naslov-sodniki">
                <h2>SODNIKI</h2>
                <p>
                    Društvo atletskih sodnikov AK Šentjur, je bilo ustanovljeno 7.10.2005. Člani društva so predvsem nekdanji atleti in ljubitelji atletike. 
                    Od leta 2003 je določeno število atletov v AK Šentjur, zaključilo s tekmovalno aktivnostjo, bodi si zaradi študijskih obveznosti, ali družinskih obveznosti
                </p>
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
        </div>
    </main>
    <?php include "footer.php"; ?>
</body>
</html>
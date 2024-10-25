<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link reL="stylesheet" href="styles/treningi.css"/>
    <title>Treningi</title>
</head>
<body>
    <header>
        <?php include"config.php"; include"navigation.php" ?>
    </header>

    <main>
        <section class="explenation-box">
            <div>
                <h1>Lokacije in termini treningov</h1>
                <hr>
                <p>V sklopu kluba atletska šola deluje na 7 različnih lokacijah. Več informacij o atletski šoli in terminih treningov najdete spodaj</p>
            </div>
            <img src="../assets/time.svg" alt="">
        </section>


        <?php 
        
        $locations = [
            ['town' => 'Šentjur', 'age' => '1., 2. razred', 'location' => 'OŠ Franja Malgaja', 'time' => 'vsak torek 15:00 - 16:00', 'trener' => 'Rok Novak'],
            ['town' => 'Šentjur', 'age' => '3., ..., 5. razred', 'location' => 'OŠ Franja Malgaja', 'time' => 'vsak četrtek 15:00 - 16:00', 'trener' => 'Rok Novak'],
            ['town' => 'Šentjur', 'age' => '6., ..., 9. razred', 'location' => 'OŠ Franja Malgaja', 'time' => 'vsako soboto 15:00 - 16:00 + po dogovoru', 'trener' => 'Vladimir Artnak'],
            ['town' => 'Dramlje', 'age' => '6 - 15 let', 'location' => 'OŠ Dramlje in stadion', 'time' => 'vsak četrtek 16:00 - 17:00', 'trener' => 'Nives Artič'],
            ['town' => 'Slivnica', 'age' => '7 - 15 let', 'location' => 'OŠ Slivnica pri Celju in igrišča', 'time' => 'vsak sredo 15:15 - 16:15', 'trener' => 'Primož Pangerl'],
            ['town' => 'Podčetrtek', 'age' => '1., ..., 9. razred', 'location' => 'OŠ Podčetrtek', 'time' => 'vsak četrtek 13:00 - 14:30', 'trener' => 'Borut Pihlar'],
            ['town' => 'Lesično', 'age' => '1., ..., 9. razred', 'location' => 'OŠ Lesično', 'time' => 'za info se obrnite na trenerja', 'trener' => 'Ivan Kukovič'],
            ['town' => 'Rogatec', 'age' => 'prešolski otroci do 3. razred', 'location' => 'OŠ Podčetrtek', 'time' => 'vsak torek 14:15 - 15:00', 'trener' => 'Nives Artič'],
            ['town' => 'Rogatec', 'age' => '4., ..., 9.', 'location' => 'OŠ Podčetrtek', 'time' => 'vsak torek 15:00 - 16:00', 'trener' => 'Nives Artič']
        ]


        ?>

            <div class="filter-bar">
                <label for="filter1">Mesto |</label>
                <select id="filter1">
                    <option value="all">All</option>
                    <option value="option1">Šentjur</option>
                    <option value="option2">Option 2</option>
                </select>
            </div>

        <section class="content">
            <section class="treningi">
                <div id="id1">
                    <p><b>Starost:</b> <?php echo $locations[0]['age']; ?></p>
                    <p><b>Lokacija:</b> <?php echo $locations[0]['location']; ?></p>
                    <p><b>Čas:</b> <?php echo $locations[0]['time']; ?></p>
                    <p><b>Trener:</b> <?php echo $locations[0]['trener']; ?></p>
                    <div class="header">
                        <h2><?php echo $locations[0]['town']; ?></h2>
                    </div>
                </div>
                <div id="id2">
                    <p><b>Starost:</b> <?php echo $locations[1]['age']; ?></p>
                    <p><b>Lokacija:</b> <?php echo $locations[1]['location']; ?></p>
                    <p><b>Čas:</b> <?php echo $locations[1]['time']; ?></p>
                    <p><b>Trener:</b> <?php echo $locations[1]['trener']; ?></p>
                    <div class="header">
                        <h2><?php echo $locations[1]['town']; ?></h2>
                    </div>
                </div>
                <div id="id3">
                    <p><b>Starost:</b> <?php echo $locations[2]['age']; ?></p>
                    <p><b>Lokacija:</b> <?php echo $locations[2]['location']; ?></p>
                    <p><b>Čas:</b> <?php echo $locations[2]['time']; ?></p>
                    <p><b>Trener:</b> <?php echo $locations[2]['trener']; ?></p>
                    <div class="header">
                        <h2><?php echo $locations[2]['town']; ?></h2>
                    </div>
                </div>
            </section>
        </section>
    </main>


        <?php include "footer.php"; ?>
</body>
</html>
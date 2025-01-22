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
                    <option value="all">Vsi treningi</option>
                    <option value="sentjur">Šentjur</option>
                    <option value="dramlje">Dramlje</option>
                    <option value="slivnica">Slivnica</option>
                    <option value="podcetrtek">Podčetrtek</option>
                    <option value="lesicno">Lesično</option>
                    <option value="rogatec">Rogatec</option>
                </select>
            </div>

        <section class="content">
            <article class="treningi">
                    <div id="id1" data-town="sentjur">
                        <p><b>Starost:</b> <?php echo $locations[0]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[0]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[0]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[0]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[0]['town']; ?></h2>
                        </div>
                    </div>
                    <div id="id2" data-town="sentjur">
                        <p><b>Starost:</b> <?php echo $locations[1]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[1]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[1]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[1]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[1]['town']; ?></h2>
                        </div>
                    </div>
                    <div id="id3" data-town="sentjur">
                        <p><b>Starost:</b> <?php echo $locations[2]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[2]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[2]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[2]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[2]['town']; ?></h2>
                        </div>
                    </div>
                    <div id="id4" data-town="dramlje">
                        <p><b>Starost:</b> <?php echo $locations[3]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[3]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[3]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[3]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[3]['town']; ?></h2>
                        </div>
                    </div>
                    <div id="id5" data-town="slivnica">
                        <p><b>Starost:</b> <?php echo $locations[4]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[4]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[4]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[4]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[4]['town']; ?></h2>
                        </div>
                    </div>
                    <div id="id6" data-town="podcetrtek">
                        <p><b>Starost:</b> <?php echo $locations[5]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[5]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[5]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[5]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[5]['town']; ?></h2>
                        </div>
                    </div>
                    <div id="id7" data-town="lesicno">
                        <p><b>Starost:</b> <?php echo $locations[6]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[6]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[6]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[6]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[6]['town']; ?></h2>
                        </div>
                    </div>
                    <div id="id8" data-town="rogatec">
                        <p><b>Starost:</b> <?php echo $locations[7]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[7]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[7]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[7]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[7]['town']; ?></h2>
                        </div>
                    </div>
                    <div id="id9" data-town="rogatec">
                        <p><b>Starost:</b> <?php echo $locations[8]['age']; ?></p>
                        <p><b>Lokacija:</b> <?php echo $locations[8]['location']; ?></p>
                        <p><b>Čas:</b> <?php echo $locations[8]['time']; ?></p>
                        <p><b>Trener:</b> <?php echo $locations[8]['trener']; ?></p>
                        <div class="header">
                            <h2><?php echo $locations[8]['town']; ?></h2>
                        </div>
                    </div>
            </article>
        </section>
    </main>
    
    <script>
        document.getElementById("filter1").addEventListener("change", function () {
            const selectedTown = this.value; // Get the selected town from the dropdown
            const treningiDivs = document.querySelectorAll(".treningi > div"); // Select all training session divs

            treningiDivs.forEach(div => {
                // Show div if it matches the selected town or if 'all' is selected
                if (selectedTown === "all" || div.dataset.town === selectedTown) {
                    div.style.display = "block"; // Show the entire div, including .header
                } else {
                    div.style.display = "none"; // Hide the entire div, including .header
                }
            });
        });
    </script>

    <?php include "footer.php"; ?>
</body>
</html>
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

    <?php
    
        $query = "SELECT * FROM page_content WHERE title = 'treningi'";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $content_result = $stmt->get_result();

        if ($content_result && $content_result->num_rows > 0) {
            $content_row = $content_result->fetch_assoc();

        } else {
            //echo "<p>Ni najdenih vsebin za naslov 'atleti'.</p>";
        }


    ?>

    <main>
        <section class="explenation-box">
            <div>
                <h1>Lokacije in termini treningov</h1>
                <hr>
                <p><?php echo $content_row['section_1'] ?></p>
            </div>
            <img src="../assets/time.svg" alt="">
        </section>


        

        <?php 
        $query = "SELECT pr.*, CONCAT(p.name, ' ', p.surname) AS coach_name 
                FROM practices pr 
                JOIN coach c ON pr.id_coach = c.id 
                JOIN people p ON c.id = p.id";

        $result_practices = $conn->query($query);

        $towns = [];

        if ($result_practices && $result_practices->num_rows > 0) {
            // Zberi vsa mesta
            while ($practice_row = $result_practices->fetch_assoc()) {
                $all_practices[] = $practice_row; // Shranimo tudi za kasnejšo uporabo
                $towns[] = $practice_row['town'];
            }

            // Odstrani podvojena mesta
            $uniqueTowns = array_unique($towns);
        }
        ?>

        <div class="filter-bar">
            <label for="filter1">Mesto |</label>
            <select id="filter1">
                <option value="all">Vsi treningi</option>
                <?php
                if (!empty($uniqueTowns)) {
                    foreach ($uniqueTowns as $town) {
                        $town = htmlspecialchars($town);
                        echo "<option value=\"$town\">$town</option>";
                    }
                }
                ?>
            </select>
        </div>


        <section class="content">
            <article class="treningi">    
                    <?php foreach ($all_practices as $practice): ?>
                        <div class="practice-item" data-town="<?= htmlspecialchars($practice['town']) ?>">
                            <h3><?= htmlspecialchars($practice['town']) ?></h3>                                
                            <hr>
                            <p><strong>Trener/ka:</strong> <?= htmlspecialchars($practice['coach_name']) ?></p>
                            <p><strong>Lokacija:</strong> <?= htmlspecialchars($practice['location']) ?></p>
                            <p><strong>Starostna skupina:</strong> <?= htmlspecialchars($practice['age']) ?></p>
                            <p><strong>Urnik:</strong> <?= htmlspecialchars($practice['schedule']) ?></p>
                            <p><strong>Opomba:</strong> <?= !empty($practice['note']) ? htmlspecialchars($practice['note']) : '—' ?></p>
                        </div>
                    <?php endforeach; ?>
                    
            </article>
        </section>
    </main>
    
    <script>
    document.getElementById('filter1').addEventListener('change', function () {
        const selectedTown = this.value.toLowerCase();
        const practices = document.querySelectorAll('.practice-item');

        practices.forEach(item => {
            const town = item.getAttribute('data-town').toLowerCase();
            if (selectedTown === 'all' || town === selectedTown) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
    </script>

    </script>

    <?php include "footer.php"; ?>
</body>
</html>
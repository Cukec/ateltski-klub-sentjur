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

    <?php
    
        $query = "SELECT * FROM page_content WHERE title = 'naša ekipa'";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $content_result = $stmt->get_result();

        if ($content_result && $content_result->num_rows > 0) {
            $content_row = $content_result->fetch_assoc();

        } else {
            //echo "<p>Ni najdenih vsebin za naslov 'atleti'.</p>";
        }


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
    <div class="sub-nav">
        <ul>
            <li><a href="#vodstvo">Vodstvo</a></li>
            <li><a href="#trenerji">Trenerji</a></li>
            <li><a href="#sodniki">Sodniki</a></li>
        </ul>
    </div>
<section class="background-sec">
    <main class="first">
        <div class="staff-grid" id="vodstvo">
            <div class="staff-desc">
                <h1>Vodstvo</h1>
                <hr>
                <p><?php echo $content_row['section_2'] ?></p>
            </div>
            <div class="staff-members">
            <?php
        
            $query = "SELECT * FROM team_members ORDER BY display_order ASC";

            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="staff-member">
                    <p><strong style="text-transform: uppercase"><?= htmlspecialchars($row['function']) ?></strong> - <?= htmlspecialchars($row['name'] . ' ' . $row['surname'])?></p>
                </div>
                <?php
            }
            } else {
            echo "<p>Ni najdenih trenerjev v bazi.</p>";
            }
        
            ?>
            </div>
        </div>
    </main>
</section>

    <main>
        <div class="team-title" id="trenerji">
            <h1>Trenerji</h1>
            <hr>
            <p><?php echo $content_row['section_3']?></p>
        </div>
        <div class="team-grid">
        <?php
            $query = "SELECT * FROM coach c JOIN people p ON c.id = p.id";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="team-member">
                <div class="profile-pic">
                    <img src="<?= file_exists("../gallery/osebje/{$row['id']}.jpg") ? "../gallery/osebje/{$row['id']}.jpg" : "../assets/random-placeholder-ppl.jpg" ?>" alt="Oseba">
                </div>
                <h3 class="member-name"><?= htmlspecialchars($row['name'] . ' ' . $row['surname']) ?></h3>
                <hr>
                <div class="contact-info">
                    <p><strong>Email:</strong> <?= htmlspecialchars($row['mail']) ?></p>
                    <p><strong>Telefon:</strong> <?= htmlspecialchars($row['tel']) ?></p>
                    <p><strong>Lokacija:</strong> <?= htmlspecialchars($row['location']) ?></p>
                </div>
                </div>
                <?php
            }
            } else {
            echo "<p>Ni najdenih trenerjev v bazi.</p>";
            }
        ?>
        </div>
        
    </main>
    <main>
        <div class="team-title" id="sodniki">
            <h1>Društvo sodnikov</h1>
            <hr>
            <p><?php echo $content_row['section_4']?></p>
        </div>
        <div class="reff-grid">
            <?php
            $query = "SELECT name, surname
                    FROM people p
                    JOIN referees r ON p.id = r.id_people
                    ORDER BY surname ASC";

            $result = $conn->query($query);

            $people = [];

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $people[] = $row;
                }

                // Razdeli v 3 stolpce
                $columnCount = 3;
                $total = count($people);
                $rowsPerColumn = ceil($total / $columnCount);

                $columns = array_fill(0, $columnCount, []);
                foreach ($people as $index => $person) {
                    $columnIndex = floor($index / $rowsPerColumn);
                    if (!isset($columns[$columnIndex])) {
                        $columns[$columnIndex] = [];
                    }
                    $columns[$columnIndex][] = $person;
                }

                echo '<div class="columns-container">';
                foreach ($columns as $column) {
                    echo '<div class="column">';
                    foreach ($column as $person) {
                        echo '<p>' . htmlspecialchars($person['surname'] . ' ' . $person['name']) . '</p>';
                    }
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "<p>Ni sodnikov v bazi.</p>";
            }
            ?>
            </div>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
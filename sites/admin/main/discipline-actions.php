<?php

include('../../config.php');

$msgs = [];
$error = "false";

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])){

    if($_POST['action'] == 'delete'){

        $id = isset($_POST['discipline']) ? (int)$_POST['discipline'] : 0;

        if ($id <= 0) {
            die("Neveljaven ID.");
        }

        // DODAJ PO ŽELJI: Preveri, če obstajajo povezani podatki in opozori uporabnika

        $stmt = $conn->prepare("DELETE FROM discipline WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $msgs[] = "Discipina uspešno izbrisana.";
        } else {
            $msgs[] = "Napaka pri brisanju discipline!";
        }

        $stmt->close();

        $status_msg = implode(" ", $msgs);
        header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));

    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AK Šentjur - Urejanje disciplin</title>
    <link rel="stylesheet" href="styles/secondary.css">
    
</head>
<body>
    <?php
    
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])){

            if($_POST['action'] == 'save'){

                ?>
                <div class="title">
                    <h2>Dodajate disciplino</h2>
                    <a href="admin.php">⮨ nazaj</a>
                </div>
                <form action="add-discipline.php" method="post">
                    <div class="form-div">
                        <label for="title">Naziv discipline:</label><br>
                        <input type="text" name="title" id="title"><br>

                        <label for="type">Tip discipline:</label><br>
                        <input type="radio" name="type" id="type" value="1"><label class="check-label">tek</label><br>
                        <input type="radio" name="type" id="type" value="2"><label class="check-label">tehnična disciplina</label><br>

                        <input type="submit" value="dodaj">
                    </div>
                </form>
                
                <?php

            }else if($_POST['action'] == 'change'){

                $sql = "SELECT * FROM discipline WHERE id=?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_POST['discipline']);
                $stmt->execute();
                
                $result = $stmt->get_result();

                $row = $result->fetch_assoc();

                ?>
                    <div class="title">
                        <h2>Spreminjate disciplino</h2>
                        <a href="admin.php">⮨ nazaj</a>
                    </div>                
                    <form action="save-discipline.php" method="post">
                        <div class="form-div">

                            <input type="text" name="id" id="id" value="<?php echo $row['id']; ?>" hidden>

                            <label for="title">Naziv discipline:</label><br>
                            <input type="text" name="title" id="title" value="<?php echo $row['title'] ?>"><br>

                            <label for="type">Tip discipline:</label><br>
                            <input type="radio" name="type" id="type" value="1" <?php echo ($row['type'] == "1") ? 'checked' : '' ?>><label class="check-label">tek</label><br>
                            <input type="radio" name="type" id="type" value="2" <?php echo ($row['type'] == "2") ? 'checked' : '' ?>><label class="check-label">tehnična disciplina</label><br>

                            <input type="submit" value="SPREMENI">
                        </div>
                    </form>
                
                <?php

            }/*else if($_POST['action'] == 'delete'){

                $id = isset($_POST['discipline']) ? (int)$_POST['discipline'] : 0;

                if ($id <= 0) {
                    die("Neveljaven ID.");
                }

                // DODAJ PO ŽELJI: Preveri, če obstajajo povezani podatki in opozori uporabnika

                $stmt = $conn->prepare("DELETE FROM discipline WHERE id = ?");
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    echo "Discipina uspešno izbrisana.";
                } else {
                    echo "Napaka pri brisanju discipline: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();

            }*/else{

                echo 'Napaka pri izbiranju operacije. ( DODAJ / SPREMENI / IZBRISI )';

            }

        }

    ?>
</body>
</html>
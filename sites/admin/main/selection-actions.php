<?php
include("../../config.php");

$msgs = [];
$error = "false";

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])){
    if($_POST['action'] == "delete"){

        $id = isset($_POST['selection']) ? intval($_POST['selection']) : 0;

        if ($id <= 0) {
            die("Napaka: Napačen ali manjkajoč ID.");
        }

        // Pomembno: preveri, ali so na selekcijo vezani drugi podatki, preden izbrišeš

        $sql = "DELETE FROM selection WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $msgs[] = "Uspešno izbrisana selekcija!";
        } else {
            $msgs[] = "Napaka pri brisanju selekcije!";
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
    <link rel="stylesheet" href="styles/secondary.css">
    <title>AK Šentjur - Urejanje selekcij</title>
</head>
<body>
    <?php

        
    
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])){

            if($_POST['action'] == "save"){

                ?>
                <div class="title">
                    <h2>Dodajate selekcijo</h2>
                    <a href="admin.php">⮨ nazaj</a>
                </div>
                <form action="add-selection.php" method="POST">
                    <div class="form-div">
                        <label for="title">Naziv selekcije:</label><br>
                        <input type="text" name="title" id="title"><br>

                        <input type="submit" value="DODAJ">
                    </div>
                </form>
                
                <?php

            }else if($_POST['action'] == "change"){

                $sql = "SELECT * FROM selection WHERE id=?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_POST['selection']);
                $stmt->execute();

                $result = $stmt->get_result();

                $row = $result->fetch_assoc();

                ?>

                <div class="title">
                    <h2>Spreminjate selekcijo</h2>
                    <a href="admin.php">⮨ nazaj</a>
                </div>
                <form action="save-selection.php" method="POST">
                    <div class="form-div">
                        <input type="text" name="id" id="id" value="<?php echo $row['id'] ?>" hidden>

                        <label for="title">Naziv selekcije:</label><br>
                        <input type="text" name="title" id="title" value="<?php echo $row['title'] ?>"><br>

                        <input type="submit" value="SPREMENI">
                    </div>
                </form>
                
                <?php

            }/*else if($_POST['action'] == "delete"){

                $id = isset($_POST['selection']) ? intval($_POST['selection']) : 0;

                if ($id <= 0) {
                    die("Napaka: Napačen ali manjkajoč ID.");
                }

                // Pomembno: preveri, ali so na selekcijo vezani drugi podatki, preden izbrišeš

                $sql = "DELETE FROM selection WHERE id = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    echo "USPEŠNO izbrisana selekcija!";
                } else {
                    echo "NAPAKA pri brisanju selekcije!";
                }

                $conn->close();

            }*/else{

                echo "Napaka pri izbiranju operacije ( DODAJ / SPREMENI / IZBRISI )";

            }

        }
    
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        include("../../config.php");
    
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])){

            if($_POST['action'] == "save"){

                ?>
                
                <form action="add-selection.php" method="POST">

                    <label for="title">Naziv selekcije:</label><br>
                    <input type="text" name="title" id="title"><br>

                    <input type="submit" value="DODAJ">

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
                
                <form action="save-selection.php" method="POST">

                    <input type="text" name="id" id="id" value="<?php echo $row['id'] ?>" hidden>

                    <label for="title">Naziv selekcije:</label><br>
                    <input type="text" name="title" id="title" value="<?php echo $row['title'] ?>"><br>

                    <input type="submit" value="SPREMENI">

                </form>
                
                <?php

            }else if($_POST['action'] == "delete"){

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

            }else{

                echo "Napaka pri izbiranju operacije ( DODAJ / SPREMENI / IZBRISI )";

            }

        }
    
    ?>
</body>
</html>
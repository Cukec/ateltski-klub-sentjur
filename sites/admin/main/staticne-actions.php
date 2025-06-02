<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/secondary.css">
    <title>AK Šentjur - Urejanje 'statičnih'</title>
</head>
<body>
    <?php
    
    include('../../config.php');

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)){

        $id = isset($_POST['static']) ? $_POST['static'] : 0;


        if($id > 0){

            $sql = "SELECT * FROM page_content WHERE id=?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $result = $stmt->get_result();

            if($row = $result->fetch_assoc()){

                $title = $row['title'];
                $section1 = $row['section_1'];
                $section2 = $row['section_2'];
                $section3 = $row['section_3'];
                $section4 = $row['section_4'];

            }


            ?>

            <div class="title">
                <h2>Spreminjate vsebino statičnih strani</h2>
                <a href="admin.php">⮨ nazaj</a>
            </div>

            <h3><?php echo $title ?></h3>
            <i style="color: #ccc;">Info: Če je odstavek prazen pomeni, da tisti odstavek ni vsebina strani.</i><br>
            <i style="color: #ccc;">Npr.: če imajo vsebino samo trije odstavki, pomeni da se na tej strani nahajajo le trije odstavki -> četrti prazen</i><br>

            
            <form action="save-static.php" method="POST">
                <div class="form-div">
                    <input type="text" name="id" id="id" value="<?php echo $id ?>"hidden>

                    <label for="section_1">1. Odstavek:</label><br>
                    <textarea class="static" name="section_1" id="section_1" ><?php echo $section1 ?></textarea><br>
                    <label for="section_2">2. Odstavek:</label><br>
                    <textarea class="static" name="section_2" id="section_2" ><?php echo $section2 ?></textarea><br>
                    <label for="section_3">3. Odstavek:</label><br>
                    <textarea class="static" name="section_3" id="section_3" ><?php echo $section3 ?></textarea><br>
                    <label for="section_4">4. Odstavek:</label><br>
                    <textarea class="static" name="section_4" id="section_4" ><?php echo $section4 ?></textarea><br>

                    <input type="submit" value="posodobi">
                </div>
            </form>
            
            <?php

        }

        

    }else{



    }
    

    ?>
</body>
</html>
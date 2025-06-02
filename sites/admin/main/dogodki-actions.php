<?php

include("../../config.php");

$msg = "";
$error = "false";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['news']) ? (int)$_POST['news'] : 0; // Selected news ID

    if ($action === "delete" && $id > 0) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if ($id > 0) {
                $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
                $stmt->bind_param("i", $id);
                    
                if ($stmt->execute()) {
                    //echo "Dogodek uspešno izbrisan!";
                    $msg = "Uspešno brisanje vsebine!";

                }else {
                    //echo "Napaka pri brisanju dogodka: " . $stmt->error;
                    $msg = "Napaka pri bridanju vsebine! Poskusite znova...";
                    $error = "true";
                }
            
                $stmt->close();
            } else {
                //echo "Napaka: Neveljaven ID dagodka.";
                $msg = "Napaka pri bridanju vsebine! Poskusite znova...";
                $error = "true";
            }
        }

        header("location: admin.php?status_msg=" . urlencode($msg) . "&error=" . urlencode($error));
        exit;

    }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/secondary.css">
    <title>Document</title>
</head>
<header>
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/u336cycduxe8y6tqewtt8ylyrx1zi5rlqauhgtozzsx80cg9/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
    tinymce.init({
    selector: 'textarea', // Target all textarea elements
    plugins: 'link image imagetools', // Include the link plugin
    toolbar: 'undo redo | bold italic underline | link', // Add link button to the toolbar
    placeholder: 'Vpišite vsebino...',
    menu: {
        edit: { title: 'Edit', items: 'undo, redo, selectall' },
        insert: { title: 'Insert', items: 'link image' }
    },
    height: 500, // Set the height in pixels
    width: '100%', // Set the width to fit the form or a specific value like '600px'
    resize: true // Allow users to manually resize the editor (optional)
    });
    </script>

</header>
<body>
    
<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['news']) ? (int)$_POST['news'] : 0; // Selected news ID

    if ($action === "save") {
        
        //FORM za dodajanje dogodka
        ?>
        
        <form action="add-event.php" method="POST">
            <div class="form-div">
                <div class="title">
                    <h2>Dodajate dogodek</h2>
                    <a href="admin.php">⮨ nazaj</a>
                </div>

                <input type="text" name="title" id="title" placeholder="Naslov">
                
                <input type="text" name="location" id="location" placeholder="Kraj dogodka">

                <select name="type">
                    <option value="1">Tekmovanje</option>
                    <option value="2">Dogodek</option>
                </select>
                
                <label for="date_start">Začetek</label>
                <input class="custom-date" type="date" name="date_start" id="date_start">
                
                <label for="date_end">Konec</label>
                <input class="custom-date" type="date" name="date_end" id="date_end">
                
                <textarea name="content" id="content" ></textarea>

                <button type="submit">Dodaj</button>

                <div class="info">
                    <i>🛈 polj NASLOV in VSEBINA ne puščajte praznih, drugače bo prišlo do napčnih podatkov v bazi.</i>
                </div>
            </div>
        </form>

        
        <?php

    } elseif ($action === "change" && $id > 0) {
        
        $stmt = $conn->prepare("SELECT type, title, content, `location`, date_start, date_end FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Bind result variables
        $stmt->bind_result($type, $title, $content, $location, $date_start, $date_end);

        if ($stmt->fetch()) {
            $event = ['type' => $type, 'title' => $title, 'content' => $content, 'location' => $location, 'date_start' => $date_start, 'date_end' => $date_end];
        }

        $stmt->close();
        ?>
        
        <form action="save-event.php" method="POST">
            <div class="form-div">
                <div class="title">
                    <h2>Spreminjate dogodek</h2>
                    <a href="admin.php">⮨ nazaj</a>
                </div>

                <input type="hidden" name="id" value="<?= $id ?>"> <!-- Hidden field for ID -->

                <input type="text" name="title" id="title" placeholder="Naslov" value="<?= $event['title'] ?>">


                <input type="text" name="location" id="location" placeholder="Kraj" value="<?= $event['location'] ?>">

                <select name="type">
                    <option value="1" <?= $event['type'] == 1 ? 'selected' : '' ?>>Tekmovanje</option>
                    <option value="2" <?= $event['type'] == 2 ? 'selected' : '' ?>>Dogodek</option>
                </select>

                <label for="date_start">Začetek</label>
                <input class="custom-date" type="date" name="date_start" id="date_start" value="<?= $event['date_start'] ?>" >

                <label for="date_end">Konec</label>
                <input class="custom-date" type="date" name="date_end" id="date_end" value="<?= $event['date_end'] ?>">

                <textarea name="content" id="content"><?= $event['content'] ?></textarea>

                <button type="submit">Shrani</button>

                <div class="info">
                    <i>🛈 polj NASLOV, KRAJ in VSEBINA ne puščajte praznih, drugače bo prišlo do napčnih podatkov v bazi.</i>
                </div>
            </div>
        </form>
        
        <?php
        
    } else {
        echo "Invalid request!";
    }

}
?>


</body>
</html>


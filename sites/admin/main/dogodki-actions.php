<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <?php include("../../config.php"); ?>

</header>
<body>
    
<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['news']) ? (int)$_POST['news'] : 0; // Selected news ID

    if ($action === "save") {
        
        //FORM za dodajanje novice
        ?>
        
        <form action="add-event.php" method="POST">
            <label for="title">Naslov:</label>
            <input type="text" name="title" id="title" placeholder="Naslov" >

            <label for="place">Kraj:</label>
            <input type="text" name="location" id="location" placeholder="Kraj dogodka" >

            <label for="date_start">Začetek:</label>
            <input type="date" name="date_start" id="date_start">

            <label for="date_end">Konec:</label>
            <input type="date" name="date_end" id="date_end">

            <label for="content">Vsebina:</label>
            <textarea name="content" id="content" ></textarea>

            <label for="shown">Tip:</label>
            <select name="type">
                <option value="1">Tekovanje</option>
                <option value="2">Dogodek</option>
            </select>


            <button type="submit">Dodaj</button>
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
            <input type="hidden" name="id" value="<?= $id ?>"> <!-- Hidden field for ID -->

            <label for="title">Naslov:</label>
            <input type="text" name="title" id="title" placeholder="Naslov" value="<?= $event['title'] ?>">

            <label for="title">Kraj:</label>
            <input type="text" name="location" id="location" placeholder="Kraj" value="<?= $event['location'] ?>">

            <label for="date_start">Začetek:</label>
            <input type="date" name="date_start" id="date_start" value="<?= $event['date_start'] ?>" >

            <label for="date_end">Konec:</label>
            <input type="date" name="date_end" id="date_end" value="<?= $event['date_end'] ?>">

            <label for="content">Vsebina:</label>
            <textarea name="content" id="content"><?= $event['content'] ?></textarea>

            <label for="type">Tip:</label>
            <select name="type">
                <option value="1" <?= $event['type'] == 1 ? 'selected' : '' ?>>Tekovanje</option>
                <option value="2" <?= $event['type'] == 2 ? 'selected' : '' ?>>Dogodek</option>
            </select>

            <button type="submit">Shrani</button>
        </form>
        
        <?php
        


    } elseif ($action === "delete" && $id > 0) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            if ($id > 0) {
                $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
                $stmt->bind_param("i", $id);
                
                if ($stmt->execute()) {
                    echo "Dogodek uspešno izbrisan!";
                } else {
                    echo "Napaka pri brisanju dogodka: " . $stmt->error;
                }
        
                $stmt->close();
            } else {
                echo "Napaka: Neveljaven ID dagodka.";
            }
        }

    } else {
        echo "Invalid request!";
    }

}
?>


</body>
</html>


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
        
        <form action="add-news.php" method="POST">
            <label for="title">Naslov:</label>
            <input type="text" name="title" id="title" placeholder="Naslov" >

            <label for="content">Vsebina:</label>
            <textarea name="content" id="content" ></textarea>

            <label for="shown">Prikazano:</label>
            <select name="shown">
                <option value="1">Da</option>
                <option value="0">Ne</option>
            </select>

            <button type="submit">Dodaj</button>
        </form>

        
        <?php

    } elseif ($action === "change" && $id > 0) {
        
        $stmt = $conn->prepare("SELECT title, content, shown FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Bind result variables
        $stmt->bind_result($title, $content, $shown);

        if ($stmt->fetch()) {
            $news = ['title' => $title, 'content' => $content, 'shown' => $shown];
        }

        $stmt->close();
        ?>
        
        <form action="save-news.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>"> <!-- Hidden field for ID -->

            <label for="title">Naslov:</label>
            <input type="text" name="title" id="title" placeholder="Naslov" value="<?= $news['title'] ?>" required>

            <label for="content">Vsebina:</label>
            <textarea name="content" id="content" required><?= $news['content'] ?></textarea>

            <label for="shown">Prikazano:</label>
            <select name="shown">
                <option value="1" <?= $news['shown'] == 1 ? 'selected' : '' ?>>Da</option>
                <option value="0" <?= $news['shown'] == 0 ? 'selected' : '' ?>>Ne</option>
            </select>

            <button type="submit">Shrani</button>
        </form>
        
        <?php
        


    } elseif ($action === "delete" && $id > 0) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            if ($id > 0) {
                $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
                $stmt->bind_param("i", $id);
                
                if ($stmt->execute()) {
                    echo "Novica uspešno izbrisana!";
                } else {
                    echo "Napaka pri brisanju novice: " . $stmt->error;
                }
        
                $stmt->close();
            } else {
                echo "Napaka: Neveljaven ID novice.";
            }
        }

    } else {
        echo "Invalid request!";
    }

}
?>


</body>
</html>


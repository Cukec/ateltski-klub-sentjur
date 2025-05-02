<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/admin-individual.css">
    <title>Admin - Novice</title>
</head>
<body>
    <header>

        <?php 

            include"config.php"; include"navigation.php";
            
            $acition = $_GET["action"];
            $id = isset($_GET["id"]);

            echo "id: ".$id;
            
        ?>

        <!-- TINY MCE - inicializacija -->
        <script src="https://cdn.tiny.cloud/1/u336cycduxe8y6tqewtt8ylyrx1zi5rlqauhgtozzsx80cg9/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

        <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
        <script>
        tinymce.init({
        selector: 'textarea', // Target all textarea elements
        plugins: 'link image imagetools', // Include the link plugin
        toolbar: 'undo redo | bold italic underline | link', // Add link button to the toolbar
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
    
    <main>

        <h2><?php echo $acition; ?> novico</h2>
        <hr>

        <div class="form-container">
            <form id="novice" action="submit-news.php" method="POST" enctype="multipart/form-data">
                <label for="">Naslov</label>
                <input type="text" id="title" name="title">
                <label for="">Vsebina</label>
                <textarea id="content" name="content"></textarea>
                <input type="hidden" id="newsId" name="newsId">
                <input id="submit" name="submit" value="<?php echo $acition; ?>" type="submit">
            </form>
        </div>

    </main>
    
    <?php include"footer.php"; ?>
</body>
</html>
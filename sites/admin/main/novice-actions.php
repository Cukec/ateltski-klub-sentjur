<?php
include("../../config.php");

$msg = "";
$error = "false";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['news']) ? (int)$_POST['news'] : 0;

    if ($action === "delete" && $id > 0) {
        $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $msg = "Uspešno izbrisana novica.";
            $error = "false";
        } else {
            $msg = "Napaka pri brisanju novice: " . $stmt->error;
            $error = "true";
        }

        $stmt->close();

        // Redirect with status message before output
        header("Location: admin.php?status_msg=" . urlencode($msg) . "&error=" . urlencode($error));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
    <link rel="stylesheet" href="styles/secondary.css" />
    <script src="https://cdn.tiny.cloud/1/u336cycduxe8y6tqewtt8ylyrx1zi5rlqauhgtozzsx80cg9/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
        selector: 'textarea',
        plugins: 'link image imagetools',
        toolbar: 'undo redo | bold italic underline | link image',
        placeholder: 'Vpišite vsebino...',
        menu: {
            edit: { title: 'Edit', items: 'undo, redo, selectall' },
            insert: { title: 'Insert', items: 'link image' }
        },
        height: 500,
        width: '50vw',
        resize: true,

        // 👇 Added for relative image paths
        relative_urls: true,
        remove_script_host: true,
        convert_urls: true,
        document_base_url: '../../../gallery/tinymce/',

        // Optional: enable image upload via drag/drop or paste
        automatic_uploads: true,
        images_upload_url: 'tinymce-upload.php', // Uncomment and adjust if you want upload handling
    });

    </script>
</head>
<body>

<?php
// Handle other actions like save or change (display forms, etc)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['news']) ? (int)$_POST['news'] : 0;

    if ($action === "save") {
        ?>
        <form action="add-news.php" method="POST">
            
            <div class="form-div">
                <div class="title">
                    <h2>Dodajate novico</h2>
                    <a href="admin.php">⮨ nazaj</a>
                </div>
                <div>
                    <input type="text" name="title" id="title" placeholder="Naslov" />
                    <select name="shown">
                        <option value="1">prikazano</option>
                        <option value="0">skrito</option>
                    </select>
                </div>
                <textarea name="content" id="content"></textarea>
                <button type="submit">Dodaj</button>
                <div class="info">
                    <i>🛈 polj NASLOV in VSEBINA ne puščajte praznih, drugače bo prišlo do napčnih podatkov v bazi.</i>
                </div>
            </div>
        </form>
        <?php
    } elseif ($action === "change" && $id > 0) {
        $stmt = $conn->prepare("SELECT title, content, shown FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($title, $content, $shown);

        if ($stmt->fetch()) {
            $news = ['title' => $title, 'content' => $content, 'shown' => $shown];
        }
        $stmt->close();
        ?>
        <form action="save-news.php" method="POST">
            <div class="form-div">
                <div class="title">
                    <h2>Spreminjate novico</h2>
                    <a href="admin.php">⮨ nazaj</a>
                </div>
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>" />
                <input type="text" name="title" id="title" placeholder="Naslov" value="<?= htmlspecialchars($news['title']) ?>" required />
                <select name="shown">
                    <option value="1" <?= $news['shown'] == 1 ? 'selected' : '' ?>>prikazano</option>
                    <option value="0" <?= $news['shown'] == 0 ? 'selected' : '' ?>>skrito</option>
                </select>
                <textarea name="content" id="content" required><?= htmlspecialchars($news['content']) ?></textarea>
                <button type="submit">Shrani</button>
                <div class="info">
                    <i>🛈 polj NASLOV in VSEBINA ne puščajte praznih, drugače bo prišlo do napčnih podatkov v bazi.</i>
                </div>
            </div>
        </form>
        <?php
    } else {
        echo "Invalid request!";
    }
} else {
    echo "Invalid request!";
}
?>

</body>
</html>

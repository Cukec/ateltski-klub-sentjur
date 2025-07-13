<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Klubu AK Sentjur</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles/o-klubu.css">
</head>
<body>
    <?php include "navigation.php";  include "config.php"; ?>

    <?php
    
        $query = "SELECT * FROM page_content WHERE title = 'o klubu'";

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
                <h1>Predstavitev AK Šentjur</h1>
                <hr>
                <p>
                    <?php echo $content_row['section_1'] ?>
                </p>
            </div>
            <div class="atletska-sola">
                <a href="treningi.php"><img src="../assets/logo-atletska-sola.png" alt="logo-atletska-sola"></a>
            </div>
        </section>

        <div class="sub-nav" id="past-events-section">
            <ul>
                <li><a href="#predstavitev">Predstavitev</a></li>
                <li><a href="#dokumenti">Dokumenti</a></li>
                <li><a href="#kakoDoNas">Kako do nas</a></li>
            </ul>
        </div>
    
    <main>

        

        <section id="predstavitev">
            <article class="predstavitev">
                <h2>Predstavitev</h2>
                <hr>
                <p><?php echo $content_row['section_2'] ?></p>
            </article>
            <article class="zgodovina">
                <h2>Zgodovina</h2>
                <hr>
                <p>
                    <?php echo $content_row['section_3'] ?>
                </p>
            </article>
        </section>
        <!-- skripta za filetree -->
        <script>
            $(document).ready(function() {
                // Function to load file tree
                function loadFileTree(path, $parent) {
                    $.ajax({
                        url: 'fetch-file-tree.php', // PHP script to fetch the file tree
                        type: 'GET',
                        data: { folder: path },
                        dataType: 'json',
                        success: function(data) {
                            buildFileTree(data, $parent);
                        },
                        error: function() {
                            alert('Error loading file tree');
                        }
                    });
                }

            // Function to build the file tree from JSON data
            function buildFileTree(data, $parent) {
                data.forEach(function(item) {
                    let $li = $('<li></li>').addClass(item.type);
                    $li.text(item.name);

                    if (item.type === 'folder') {
                        $li.addClass('folder');
                        let $subTree = $('<ul class="hidden"></ul>');
                        $li.append($subTree);

                        // Click event to toggle folder open/close
                        $li.on('click', function(e) {
                            e.stopPropagation(); // Prevent event bubbling

                            // Check if folder is already open
                            if ($li.hasClass('open')) {
                                $subTree.addClass('hidden'); // Hide subfolder contents
                                $li.removeClass('open'); // Toggle folder to closed state
                            } else {
                                // If the folder is closed, load its contents (if not already loaded)
                                if ($subTree.children().length === 0) {
                                    loadFileTree(item.path, $subTree); // Load subfolder contents only if not already loaded
                                }
                                $subTree.removeClass('hidden'); // Show subfolder contents
                                $li.addClass('open'); // Toggle folder to open state
                            }
                        });
                    } else {
                        $li.addClass('file');

                        // Attach click event to trigger file download
                        $li.on('click', function(e) {
                            e.stopPropagation(); // Prevent event bubbling

                            // Create a hidden download link and trigger download
                            const downloadLink = document.createElement('a');
                            downloadLink.href = item.path; // File path
                            downloadLink.download = item.name; // File name
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        });
                    }

                    $parent.append($li);
                });
            }

                // Initialize file tree with the desired folder path
                loadFileTree('admin/main/filegator/repository', $('#fileTree')); // Change this to your target folder path
            });
        </script>
    </main>
    <hr class="spacer">
    <section class="dokumenti" id="dokumenti">
            <article class="dokumenti-article">
                <div class="file-tree-container">
                    <div class="title"><h2>Dokumenti</h2></div>
                    <ul class="file-tree" id="fileTree"></ul>
                </div>
            </article>
        </section>
        <hr class="spacer">
        <section class="kako-do-nas" id="kakoDoNas">
            <h2>Najdete nas tukaj</h2>
            <img src="../assets/arrow-right.png" height="25px" width="25px">
            <article class="kako-do-nas-article">
                <div class="google-maps">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1951.9571870400787!2d15.392774675641492!3d46.2207124080434!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476577c4e12dcb29%3A0xcf26706d232b88ea!2sAtletski%20klub%20%C5%A0entjur!5e0!3m2!1sen!2ssi!4v1731767342342!5m2!1sen!2ssi" 
                        width="600" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </article>
        </section>
    <?php include("footer.php"); ?>
</body>
</html>
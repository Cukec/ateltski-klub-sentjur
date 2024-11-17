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
    
    <main>

        <section class="atleti-info">
            <div class="description-main">
                <h1>Vodstvo, trenerji in sodniki</h1>
                <hr>
                <p>Atletski klub je zavezan spodbujanju športnega duha, timskega dela in osebne rasti vseh svojih članov. Vodstvo kluba sestavljajo trenerji in strokovnjaki navdušeni nad atletiko.</p>
            </div>
            <div class="atletska-sola">
                <a href="treningi.php"><img src="../assets/logo-atletska-sola.png" alt="logo-atletska-sola"></a>
            </div>
        </section>

        <div class="nav-dogodki" id="past-events-section">
            <ul>
                <li><p>Predstavitev</p></li>
                <li><p>Dokumenti</p></li>
                <li><p>Kako do nas</p></li>
            </ul>
        </div>

        <section class="predstavitev-zgodovina">
            <article class="predstavitev">
                <h2>Predstavitev</h2>
                <p>Atletski klub Šentjur deluje na področju občine Šentjur in pokriva tudi področje širšega Kozjanskega. 
                V klubu se ukvarjamo s tekmovalno atletiko, šolsko atletiko, spodbujamo pa tudi rekreativno ukvarjanje s tekom. 
                Organiziran imamo svoj sodniški zbor tako, da organiziramo tudi atletska tekmovanja na vseh naštetih področjih. 
                Vse, ki vas zanima aktivno sodelovanje ali delo v klubu nas preko naših kontaktnih naslovov obvestite in radi vas bomo sprejeli medse. 
                AK Šentjur ima tudi status nevladne organizacije v javnem interesu na področju športa, ki mu lahko po veljavni zakonodaji namenite del dohodnine. 
                Smo člani naslednjih sorodnih zvez in organizacij:</p>
                <ul>
                    <li>Atletske zveze Slovenije</li>
                    <li>Športne unije Slovenije</li>
                    <li>Športne zveze Šentjur</li>
                </ul>
            </article>
            <article class="zgodovina">
                <h2>Zgodovina</h2>
                <p>
                    Atletski klub Šentjur je bil ustanovljen leta 1994. Ustanovni člani so bili štirje nekdanji atleti celjskega atletskega kluba: Cmok Samo, Kukovič Ivan, Podgoršek Andrej in Artnak Vlado, 
                    ki je do takrat deloval v Celju tudi kot atletski trener. Med podporniki ustanovitve sta bila tudi Gradišnik Marjan, 
                    takratni ravnatelj OŠ Franja Malgaja Šentjur in Jože Artnak, takrat aktiven v lokalni skupnosti.
                </p>
                <p>
                    Atletski klub Šentjur je bil ustanovljen s ciljem, nuditi možnost talentiranim otrokom in mladini iz občine Šentjur in širšega Kozjanskega vadbo in treninge atletike bližje kraju bivanja. 
                    Motiv za ustanovitev pa je bil predvsem v dejstvu, da so številni uspešni atleti iz tega okolja svoje rezultate dosegali za klub in kraj drugje.
                </p>
                <p>
                    Prvi predsednik Atletskega kluba Šentjur je postal Marjan Gradišnik, ki je bil to vse do leta 2011. Leta 2010 prejme tudi posebno priznanje župana Občine Šentjur za vodenje našega AK.  
                    Na rednem volilnem občnem zboru leta 2011 ga nasledi za 4 leta Vladimir Artnak, ki je eden izmed ustanoviteljev in trenerjev v klubu. 
                    V letu 2014 smo s svečano kulturno prireditvijo obeležili 20. obletnico delovanja kluba in izdali ZBORNIK Šentjurske atletike 1994 - 2014. 
                    Konec leta 2014 postane na rednem volilnem občnem zboru predsednik Jože Artnak,  dolgoletni atletski delavec, atletski sodnik in že član IO ter rekreativni tekač. 
                    Ponovno je za predsednika izvoljen leta 2018 ter 2023. V letu 2024 obeležujemo 30. obletnico našega društva.
                </p>
                <p>
                    Klub v vseh letih goji pozitivni odnos do športa in kraja ter vzgaja mlade predvsem v duhu pripadnosti idejam športa in predvsem atletike. 
                    Vsako leto uspemo vpisati v šolo atletike od 60 do 120 otrok, v mladinski in članski kategoriji pa je aktivnih od 6 do 16 atletov. 
                    Ob tem se lahko pohvalimo tudi s številnimi rezultati, uspehi in dosežki, ki so ponesli ime našega kraja po Sloveniji in navzven. To so:
                </p>
            </article>
        </section>

        <section class="dokumenti">
            <div class="custom-shape">
                <h2>Uporabni Dokumenti</h2>
                <p>
                    Skozi leta delovanja AK Šentjur se je nabralo nekaj uporabnih dokumentov. Najdete in jih lahko spodaj, s klikom na datoteko pa jo prenesete.
                </p>
            </div>


            <div class="file-tree-container">
                <div class="title"><h2>Dokumenti</h2></div>
                <ul class="file-tree" id="fileTree"></ul>
            </div>
        </section>

        <section class="kako-do-nas">
            <div class="naslov-kako-do-nas">
                <h2>Kako do Nas</h2>
            </div>
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
        </section>

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
                loadFileTree('../documents', $('#fileTree')); // Change this to your target folder path
            });
        </script>
    </main>
</body>
</html>
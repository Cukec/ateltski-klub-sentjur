<?php
require_once '../../config.php';
/*
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/admin.css">
    <title>AKŠ Admin</title>
    <style>
        table, td, th {
        border: 1px solid;
        }

        td{

            width: fit-content;
            padding: 0 5px;

        }

        table {
        border-collapse: collapse;
        font-size: .7rem;
        }

        .dosezki{
            overflow-y: auto;
            height: 50vh;
            width: fit-content;
        }
    </style>
    <?php include "../../navigation.php"; //include "../../config.php" ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.55/css/elfinder.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.55/css/theme.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.55/js/elfinder.min.js"></script>

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
  menu: {
    edit: { title: 'Edit', items: 'undo, redo, selectall' },
    insert: { title: 'Insert', items: 'link image' }
  },
  height: 500, // Set the height in pixels
  width: '100%', // Set the width to fit the form or a specific value like '600px'
  resize: true // Allow users to manually resize the editor (optional)
});
</script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
</header>
<body>
    
    <?php if (isset($_GET['status_msg'])): ?>
<script>
window.addEventListener('DOMContentLoaded', () => {
    const rawMsgs = <?php echo json_encode($_GET['status_msg']); ?>;

    // Split by sentence or manually added separator
    const messages = rawMsgs.split(/(?<=[.!?])\s+|<br>|;/).filter(msg => msg.trim().length > 0);

    messages.forEach(msg => {
        const trimmedMsg = msg.trim();
        const lowerMsg = trimmedMsg.toLowerCase();

        const isError = lowerMsg.includes('napaka');
        const isWarning = lowerMsg.startsWith('(opozorilo)');

        const toast = document.createElement('div');
        toast.textContent = trimmedMsg;

        // Add required classes and attributes
        toast.classList.add('toast');
        toast.setAttribute('data-toast', 'true');

        // Styling
        toast.style.position = 'fixed';
        toast.style.right = '20px';
        toast.style.backgroundColor = isError 
            ? '#e74c3c'           // red
            : isWarning 
                ? '#f1c40f'       // yellow
                : '#2ecc71';      // green
        toast.style.color = '#fff';
        toast.style.padding = '12px 20px';
        toast.style.marginTop = '10px';
        toast.style.borderRadius = '6px';
        toast.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';
        toast.style.zIndex = '9999';
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s ease';

        // Offset each toast vertically if multiple
        const existingToasts = document.querySelectorAll('div[data-toast]');
        toast.style.bottom = `${20 + existingToasts.length * 60}px`;

        // Click to dismiss
        toast.addEventListener('click', () => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500);
        });

        document.body.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.style.opacity = '1';
        });

        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    });
});
</script>
    <?php endif; ?>





    <nav class="subNav">
        <select onchange="showDiv(this.value)">
            <option value="novice">Novice</option>
            <option value="dogodki">Dogodki</option>
            <option value="osebe">Osebe</option>
            <option value="stafete">Štafete</option>
            <option value="dosezki">Dosežki</option>
            <option value="discipline">Discipline</option>
            <option value="selekcije">Selekcije</option>
            <option value="galerije">Galerije</option>
            <option value="povezave">Povezave</option>
            <option value="vodstvo">Vodstvo</option>
            <option value="dokumenti">Dokumenti</option>
            <option value="staticne">Staticne strani</option>
            <option value="admini">Admini</option>
        </select>
    </nav>

<main>
    <!-- NOVICE div -->
    <div id="novice" class="contentDiv">
        <h2>Izberite novico</h2>
        <form action="novice-actions.php" method="POST">

        <select name="news" id="news">
            <?php
                $sql = "SELECT id, title FROM news ORDER BY post_time DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['title']}</option>";
                    }
                } else {
                    echo "<option value=''>Na voljo ni nobene novice</option>";
                }
            ?>
        </select>

            <button type="submit" name="action" value="save">Dodaj</button>
            <button type="submit" name="action" value="change">Spremeni</button>
            <button type="submit" name="action" value="delete">Izbriši</button>
        
        </form>
    </div>
    
    <!-- DOGODKI div -->
    <div id="dogodki" class="contentDiv">
        <h2>Izberite dogodek</h2>
        <form action="dogodki-actions.php" method="POST">

        <select name="news" id="news">
            <?php
                $sql = "SELECT id, title FROM events ORDER BY date_start DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['title']}</option>";
                    }
                } else {
                    echo "<option value=''>Na voljo ni nobene novice</option>";
                }
            ?>
        </select>

            <button type="submit" name="action" value="save">Dodaj</button>
            <button type="submit" name="action" value="change">Spremeni</button>
            <button type="submit" name="action" value="delete">Izbriši</button>
        
        </form>
    </div>

    <!-- OSEBE div -->
    <div id="osebe" class="contentDiv">
        <h2>Izberite osebo</h2>
        <form action="osebe-actions.php" method="POST">

        <select name="people" id="people">
            <option disabled>-- Ljudje --</option>
            <?php
                // Fetch all individuals (those with a first name)
                $stmt = $conn->prepare("SELECT id, CONCAT(surname, ' ', name) AS fullname 
                                        FROM people 
                                        WHERE name IS NOT NULL AND name != '' ORDER BY fullname");
                $stmt->execute();
                $peopleResult = $stmt->get_result();

                if ($peopleResult->num_rows > 0) {
                    while ($person = $peopleResult->fetch_assoc()) {
                        echo "<option value='{$person['id']}'>{$person['fullname']}</option>";
                    }
                } else {
                    echo "<option disabled>Ni posameznikov</option>";
                }
            ?>

        </select>

            <button type="submit" name="action" value="save">Dodaj</button>
            <button type="submit" name="action" value="change">Spremeni</button>
            <button type="submit" name="action" value="delete">Izbriši</button>
        
        </form>
    </div>
    
    <!-- ŠTAFETE div -->
    <div id="stafete" class="contentDiv">
        <h2>Izberite štafeto</h2>
        <form action="relay-actions.php" method="POST">
            <select name="relays" id="relays">
                <option disabled>-- Štafete --</option>
                <?php
                    // Fetch all relays (those without a first name)
                    $stmt = $conn->prepare("SELECT id, surname AS fullname FROM people WHERE name IS NULL OR name = ''");
                    $stmt->execute();
                    $relayResult = $stmt->get_result();

                    if ($relayResult->num_rows > 0) {
                        while ($relay = $relayResult->fetch_assoc()) {
                            echo "<option value='{$relay['id']}'>{$relay['fullname']}</option>";
                        }
                    } else {
                        echo "<option disabled>Ni štafet</option>";
                    }
                ?>
            </select>

            <button type="submit" name="action" value="save">Dodaj</button>
            <button type="submit" name="action" value="change">Spremeni</button>
            <button type="submit" name="action" value="delete">Izbriši</button>
        
        </form>
    </div>

    <!-- DOSEŽKI div -->
    <div id="dosezki" class="contentDiv">
    <h2>Urejate dosežke</h2>

    <a id="addLink" href="add-accom.php">Dodaj nov dosežek</a>

    <table>
        <thead>
            <tr>
                <th>Operacije</th>
                <th>Datum</th>
                <th>Oseba</th>
                <th>Selekcija</th>
                <th>Disciplina</th>
                <th>Tehnični rez.</th>
                <th>Časovni rez.</th>
                <th>Opis</th>
                <th>Lokacija</th>
                <th>Spol</th>
            </tr>
        </thead>
        <tbody id="accomTableBody">
            <tr><td colspan="10">Loading...</td></tr>
        </tbody>
    </table>
    </div>

    <!-- GALERIJA div -->
    <div id="galerije" class="contentDiv">
        <h2>Urejate galerijo</h2>

        <input type="text" id="archive-name" placeholder="Enter archive name">
        <button id="upload-btn">Upload Files</button>
        <form action="test.php" class="dropzone" id="file-dropzone"></form>

        <?php
            $galleryDir = '../../../gallery/galerija/';
            $folders = array_filter(glob($galleryDir . '*'), 'is_dir');
        ?>
        <h1 style="margin: 1vh 0;">Pregled arhivov</h1>

        <div id="folders">
            <?php foreach ($folders as $folderPath): 
                $folderName = basename($folderPath);
            ?>
                <div class="folder" data-folder="<?= htmlspecialchars($folderName) ?>">
                    <strong class="folder-name"><?= htmlspecialchars($folderName) ?></strong>
                    <hr>
                    <div class="actions">
                        <input type="text" class="rename-input" placeholder="Novo ime">
                        <button id="actionsBtn" onclick="renameFolder(this)">✏️ Preimenuj</button>
                        <button id="actionsBtn" onclick="deleteFolder(this)">🗑️ Izbriši</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <script>
            function renameFolder(btn) {
                const folderDiv = btn.closest('.folder');
                const oldName = folderDiv.dataset.folder;
                const newName = folderDiv.querySelector('.rename-input').value.trim();

                if (!newName) return alert("Vnesi novo ime.");
                if (newName === oldName) return alert("Ime mora biti drugačno.");

                fetch('rename-folder.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ oldName, newName })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        folderDiv.querySelector('.folder-name').textContent = newName;
                        folderDiv.dataset.folder = newName;
                        folderDiv.querySelector('.rename-input').value = '';
                    } else {
                        alert("Napaka: " + data.message);
                    }
                });
            }

            function deleteFolder(btn) {
                const folderDiv = btn.closest('.folder');
                const folder = folderDiv.dataset.folder;

                if (!confirm(`Ali res želiš izbrisati mapo "${folder}"?`)) return;

                fetch('delete-folder.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ folder })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        folderDiv.remove();
                    } else {
                        alert("Napaka: " + data.message);
                    }
                });
            }
        </script>
    </div>

    <!-- SELEKCIJE div-->
    <div id="selekcije" class="contentDiv">
        <h2>Izberite selekcijo</h2>
        <form id="selectionForm" action="selection-actions.php" method="POST">
            <select name="selection" id="selection">

            <?php
            
            $stmt = $conn->prepare("SELECT * FROM selection");
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    ?>
                    
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>

                    <?php

                }

            }else{

                echo "Napaka pri pridobivanju podatkov slekcij!";
            }
            
            ?>
            </select>

            <button type="submit" name="action" value="save">Dodaj</button>
            <button type="submit" name="action" value="change">Spremeni</button>
            <button type="submit" name="action" value="delete" id="deleteBtn">Izbriši</button>

        </form>
    </div>

    <script>
    document.getElementById('selectionForm').addEventListener('submit', function(e) {
        const clickedButton = document.activeElement;

        if (clickedButton.name === 'action' && clickedButton.value === 'delete') {
            const confirmDelete = confirm("Ali si prepričan, da želiš izbrisati to selekcijo? Morda so nanjo vezani podatki!");
            if (!confirmDelete) {
                e.preventDefault(); // Prekliči oddajo obrazca
            }
        }
    });
    </script>

    <!-- DISCIPLINE div-->
    <div id="discipline" class="contentDiv">

        <h2>Izberite disciplino</h2>
        <form id="disciplineForm" action="discipline-actions.php" method="POST">
            <select name="discipline" id="discipline">

            <?php
            
            $stmt = $conn->prepare("SELECT * FROM discipline");
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    ?>
                    
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>

                    <?php

                }

            }else{

                echo "Napaka pri pridobivanju podatkov slekcij!";
            }
            
            ?>
            </select>

            <button type="submit" name="action" value="save">Dodaj</button>
            <button type="submit" name="action" value="change">Spremeni</button>
            <button type="submit" name="action" value="delete" id="deleteBtn">Izbriši</button>

        </form>
    </div>
    
    <!-- POVEZAVE div-->
    <div id="povezave" class="contentDiv">
        <h2>Urejate povezave</h2>
        <select name="povezava" name="povezava" id="povezava" size="5" onchange="populateForm(this)">

        <?php

        $sql = "SELECT * FROM links";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()){

            ?>
            
            <option 
                value="<?php echo $row['id'] ?>" 
                data-title="<?php echo htmlspecialchars($row['title'], ENT_QUOTES) ?>" 
                data-url="<?php echo htmlspecialchars($row['url'], ENT_QUOTES) ?>">
                <?php echo $row['title'] ?>
            </option>


            <?php

        }

        ?>

        </select>

        <form action="povezave-actions.php" method="POST" onsubmit="return confirmDelete(event)">

            <input type="text" name="id" id="id" value="" hidden>

            <label for="title">Naziv strani: </label>
            <input type="text" id="title" name="title" value="">

            <label for="url">povezava: </label>
            <input type="text" name="url" id="url" value=""><br>

            <input type="submit" name="action" id="action" value="dodaj">
            <input type="submit" name="action" id="action" value="spremeni">
            <input type="submit" name="action" id="action" value="izbriši">

        </form>
        
    </div>

    <!-- DOKUMENTI div-->
    <div id="dokumenti" class="contentDiv">
        <h2>Urejate dokumente</h2>

        <div class="iframe-container">
            <iframe src="filegator/index.php" scrolling="no" style="width:100%; height: 700px;"></iframe>
        </div>
        
    </div>


    <!-- VODSTVO div-->
    <div id="vodstvo" class="contentDiv">
        <h2>Urejate vodstvo kluba</h2>
        <table id="teamTable" class="display-table">
            <thead>
                <tr>
                <th>Ime</th>
                <th>Priimek</th>
                <th>Funkcija</th>
                <th>Iizpis</th>
                <th>Operacije</th>
                </tr>
            </thead>
            <tbody id="teamBody">
                <!-- Filled by JS from DB -->
            </tbody>
        </table>
        
        <form id="addForm" onsubmit="submitAddForm(event)" style="margin-bottom: 1em;">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="surname" placeholder="Surname" required>
            <input type="text" name="function" placeholder="Function" required>
            <button type="submit" value="">Dodaj osebo</button>
        </form>

        <script src="vodstvo.js"></script>

    </div>

    

    <!-- ADMINI div -->
<div id="admini" class="contentDiv"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    loadAdmini();

    function loadAdmini() {
        fetch("fetch-admini.php")
            .then(response => response.text())
            .then(data => {
                document.getElementById("admini").innerHTML = data;
                bindFormSubmit(); // Bind form once it's loaded
            });
    }

    function bindFormSubmit() {
        const form = document.getElementById("dodaj-admin-form");
        if (!form) return;

        form.addEventListener("submit", function (e) {
            e.preventDefault(); // ❗ PREPREČI osvežitev strani

            const formData = new FormData(form);

            fetch("add-admini.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result);        // ali izpiši spodaj v div
                loadAdmini();         // ponovno naloži seznam z novo dodanim adminom
            });
        });
    }
});
</script>




    <!-- STATIČNE STRANI div-->
    <div class="contentDiv" id="staticne">
        <h2>Izberite statično stran</h2>
        <form action="staticne-actions.php" method="POST">

            <select name="static" id="static">
            <?php
            
            $sql = "SELECT * FROM page_content";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){

                ?>
                
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>
                
                <?php

            }
            
            ?>
            </select>

            <input type="submit" id="action" name="action" value="spremeni">

        </form>

    </div>
    
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = Array.from(document.querySelectorAll('button[type="submit"], input[type="submit"]'))
        .filter(btn =>
            btn.value?.toLowerCase() === "delete" ||
            btn.value?.toLowerCase() === "izbriši" ||
            btn.textContent?.toLowerCase() === "izbriši"
        );

    deleteButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            const confirmDelete = confirm("Ste prepričani, da želite izbrisati vsebino?");
            if (!confirmDelete) {
                e.preventDefault(); // Cancel submission if user clicks "Cancel"
            }
            // If user clicks "OK", form submits normally
        });
    });
});
</script>



    <script>
        // Funkcija za potrjevanje (DELETE) gumba pri povezavah
        function confirmDelete(event) {
            // Preveri, kateri gumb je bil kliknjen
            const clickedButton = event.submitter;

            if (clickedButton && clickedButton.value === "delete") {
                return confirm("Ali ste prepričani, da želite izbrisati povezavo?");
            }

            return true; // Dovoli oddajo za druge gumbe
        }
    </script>

    <script>
        // Funkcija za dodajanje vrednosti obrazca povezav
        function populateForm(select) {
            const selectedOption = select.options[select.selectedIndex];

            // Fill in the form fields
            document.getElementById('id').value = selectedOption.value;
            document.getElementById('title').value = selectedOption.getAttribute('data-title');
            document.getElementById('url').value = selectedOption.getAttribute('data-url');
        }
    </script>


    <script>
    document.getElementById('disciplineForm').addEventListener('submit', function(e) {
        const clickedButton = document.activeElement;

        if (clickedButton.name === 'action' && clickedButton.value === 'delete') {
            const confirmed = confirm("Ali ste prepričani, da želite izbrisati to disciplino? Na njo so lahko vezani podatki!");
            if (!confirmed) {
                e.preventDefault(); // Prekliči pošiljanje obrazca
            }
        }
    });
    </script>



    <script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#file-dropzone", {
        url: "test.php",
        paramName: "file",
        maxFilesize: 5, // MB
        acceptedFiles: "image/*",
        autoProcessQueue: false, // Prevents automatic upload
        parallelUploads: 9999, // Allows up to 10 files at once
        init: function () {
            let dropzoneInstance = this;

            this.on("sending", function (file, xhr, formData) {
                let archiveName = document.getElementById("archive-name").value.trim();
                if (!archiveName) {
                    alert("Please enter an archive name before uploading.");
                    dropzoneInstance.removeFile(file);
                    return;
                }
                formData.append("archive_name", archiveName);
            });

            document.getElementById("upload-btn").addEventListener("click", function () {
                if (dropzoneInstance.files.length === 0) {
                    alert("Please add files before uploading.");
                    return;
                }
                dropzoneInstance.processQueue(); // Manually process the queue
            });
        },
        
        transformFile: function(file, done) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(event) {
                var img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");

                    // Determine new dimensions
                    var width, height;
                    if (img.width > img.height) {
                        width = 800;
                        height = 535;
                    } else {
                        width = 535;
                        height = 800;
                    }

                    // Resize canvas
                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);

                    // Convert to blob and send to Dropzone
                    canvas.toBlob(function(blob) {
                        let resizedFile = new File([blob], file.name, { type: file.type });
                        done(resizedFile);
                    }, file.type);
                };
            };
        }
    });


    </script>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchAccomplishments();
});

function fetchAccomplishments() {
    fetch("fetch-admin-accomplishments.php")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("accomTableBody");
            tableBody.innerHTML = ""; // Clear existing content

            if (data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='10'>Na voljo ni nobene novice</td></tr>";
                return;
            }

            data.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>
                        <a href="save-accom.php?id=${row.id}">
                            ✏️ 
                        </a> | 
                        <a href="delete-accom.php?id=${row.id}" onclick="return confirmDeleteAccom(${row.id});">
                            🗑️
                        </a>
                    </td>
                    <td>${row.date}</td>
                    <td>${row.fullname || ""}</td>
                    <td>${row.selection || ""}</td>
                    <td>${row.discipline || ""}</td>
                    <td>${row.result_technical || ""}</td>
                    <td>${row.result_time || ""}</td>
                    <td>${row.description || ""}</td>
                    <td>${row.location || ""}</td>
                    <td>${row.gender || ""}</td>
                `;
                tableBody.appendChild(tr);
            });
        })
        .catch(error => console.error("Error fetching accomplishments:", error));
}
</script>

<script>
    function confirmDelete(event) {
        // Check if the delete button was clicked
        if (event.submitter && event.submitter.value === "delete") {
            return confirm("Ste prepričani, da želite izbrisati to novico?");
        }
        return true; // Allow other actions to proceed
    }
</script>

<script>
    // Skrivanje <div> na začetku
    const contentDivs = document.querySelectorAll('.contentDiv');
    contentDivs.forEach(div => {
        div.style.display = 'none';
    });

    // Prikaži <div>
    function showDiv(divId) {
        contentDivs.forEach(div => {
            div.style.display = 'none';
        });

        const divToShow = document.getElementById(divId);
        if (divToShow) {
            divToShow.style.display = 'block';
        }
    }
    showDiv('novice');
</script>
<script>
function confirmDeleteAccom(id) {
    // Show confirmation alert
    if (confirm('Ste prepričani, da želite izbrisati dosežek?')) {
        // If confirmed, proceed with the link action
        return true;
    } else {
        // If canceled, prevent the link action
        return false;
    }
}
</script>
<?php //include"../../footer.php" ?>

</body>
</html>
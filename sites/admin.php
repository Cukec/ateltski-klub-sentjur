<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/admin.css">
    <title>AKŠ Admin</title>
</head>
<header>
<?php include "navigation.php"; include "config.php" ?>

<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/u336cycduxe8y6tqewtt8ylyrx1zi5rlqauhgtozzsx80cg9/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
  selector: 'textarea', // Target all textarea elements
  plugins: 'link', // Include the link plugin
  toolbar: 'undo redo | bold italic underline | link', // Add link button to the toolbar
  menu: {
    edit: { title: 'Edit', items: 'undo, redo, selectall' },
    insert: { title: 'Insert', items: 'link' }
  },
  height: 500, // Set the height in pixels
  width: '100%', // Set the width to fit the form or a specific value like '600px'
  resize: true // Allow users to manually resize the editor (optional)
});
</script>

</header>
<body>
    
<nav class="subNav">
<select onchange="showDiv(this.value)">
        <option value="novice">Novice</option>
        <option value="dogodki">Dogodki</option>
        <option value="osebe">Osebe</option>
        <option value="dosezki">Dosežki</option>
        <option value="discipline">Discipline</option>
        <option value="selekcije">Selekcije</option>
        <option value="slike">Slike</option>
    </select>
    </nav>

<main>
    <!-- NEWS -->
    <div id="novice" class="contentDiv">

        <form id="novice" action="submit-news.php" method="POST" enctype="multipart/form-data">
            <label for=""><h2>Dodaj novico</h2></label>
            <label for="">Naslov</label>
            <input type="text" id="title" name="title">
            <label for="">Vsebina</label>
            <textarea rows="5" cols="50" id="content" name="content" width=""></textarea>
            <label for="">Slika</label>
            <select name="" id="">
            <select id="file-select" name="selected-file" required>
                <option value="">-- Select a file or image --</option>
                <?php include 'read-directory.php'; ?>
            </select>

            <div id="directory-buttons">
                <!-- Buttons for showing files in subdirectories will appear here -->
            </div>

            <input type="file">
            <input type="submit">
        </form>

        <script>
        // JavaScript to handle the "Show Files" button click
        document.querySelectorAll('.show-files').forEach(button => {
            button.addEventListener('click', function() {
                const dirName = this.getAttribute('data-dir');
                const filesDiv = document.getElementById('files-' + dirName);

                // Toggle visibility of the files inside the folder
                if (filesDiv.style.display === 'none') {
                    filesDiv.style.display = 'block';
                } else {
                    filesDiv.style.display = 'none';
                }
            });
        });
    </script>

        <select>                      
        <?php
            $newsQuery = "SELECT * FROM news";
            $newsResult = $conn->query($newsQuery);

            if($newsResult->num_rows > 0){
                while($row = $newsResult->fetch_assoc()){
                    ?>
                        <option id="<?php echo $row['id'] ?>"> <?php echo $row['title'] ?> </option>   
                    <?php
                }
            }
        ?>
        </select>
    </div>
    
    <!-- EVENTS -->
    <div id="dogodki" class="contentDiv">

        <form id="dogodki" action="submit-event.php" method="POST" enctype="multipart/form-data">
            <label for=""><h2>Dodaj dogodek</h2></label>
            

            <h3>Naslov</h3>
            <input type="text" id="title" name="title">

            <h3>Vsebina</h3>
            <textarea rows="5" cols="50" id="content" name="content"></textarea>

            <h3>Lokacija</h3>
            <input type="text" id="location" name="location">

            <h3>Začetek</h3>
            <input type="date" id="date_start" name="date_start">

            <h3>Začetek</h3>
            <input type="date" id="date_end" name="date_end">

            <h3>Tip dogodka</h3>
            <label for="tekmovanje"><input type="radio" name="event_type" id="event_type" value="1">Tekmovanje</label>
            <label for="tekmovanje"><input type="radio" name="event_type" id="event_type" value="2">Dogodek</label>

            <h3>Slika</h3>
            <input type="file">
            <input type="submit">
        </form>
        <div class="table-cont">
        <table>
            <tr>
                <th>Naslov</th>
                <th>Vsebina</th>
                <th class="fit">Čas objave</th>
                <th>Slika</th>
                <th>Prikazano</th>
            </tr>                      
        <?php
        
            $newsQuery = "SELECT * FROM news";

            $newsResult = $conn->query($newsQuery);

            if($newsResult->num_rows > 0){

                while($row = $newsResult->fetch_assoc()){

                    ?>
                    
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['content']; ?></td>
                            <td><?php echo $row['post_time']; ?></td>
                            <td><?php echo $row['id_image']; ?></td>
                            <td>
                                <?php 
                                    if ($row['shown'] == 1){
                                        ?> <input type="checkbox" checked> <?php
                                    }else if($row['shown'] == 0){
                                        ?> <input type="checkbox"> <?php
                                    }
                                ?>
                            </td>
                        </tr>   
                    
                    <?php

                }

            }

        ?>
        </table>
        </div>
    </div>
    
    <!-- PEOPLE -->
    <div id="osebe" class="contentDiv">
        <div>
        <form id="novice" action="submit-people.php" method="POST" enctype="multipart/form-data">
            <label for=""><h2>Dodaj osebo</h2></label>

            <label for="">Ime</label>
            <input type="text" id="name" name="name">

            <label for="">Srednje ime</label>
            <input type="text" id="middle_name" name="middle_name">

            <label for="">Priimek</label>
            <input type="text" id="surname" name="surname">

            <label for="">Opis</label>
            <textarea rows="5" cols="50" id="description" name="description"></textarea>

            <label for="">Datum rojstva</label>
            <input type="date" name="birthday">

            <label for="">Spol</label>
            <label for="male">Moški</label>
            <input type="radio" id="gender" name="gender" value="m">

            <label for="female">Ženska</label>
            <input type="radio" id="gender" name="gender" value="z">

            <label for="">Slika</label>
            <input type="file">

            <input type="submit" value="Dodaj">
        </form>
        </div>
        
        <div class="table-cont">
        <table>
            <tr>
                <th>Ime</th>
                <th>Srednje ime</th>
                <th>Priimek</th>
                <th>Opis</th>
                <th>Spol</th>
                <th class="fit">Leto rojstva</th>
                <th>Slika</th>
            </tr>                      
        <?php
        
            $newsQuery = "SELECT * FROM people WHERE surname NOT LIKE 'AK%'";

            $newsResult = $conn->query($newsQuery);

            if($newsResult->num_rows > 0){

                while($row = $newsResult->fetch_assoc()){

                    ?>
                    
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['middle_name']; ?></td>
                            <td><?php echo $row['surname']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['date_of_birth']; ?></td>
                            <td><?php echo $row['id_image']; ?></td>
                        </tr>   
                    
                    <?php

                }

            }

        ?>
        </table>
        </div>
    </div>

    <!-- DISCIPLINE -->
    <div id="discipline" class="contentDiv">
        <div>
        <form id="discipline" action="submit-discipline.php" method="POST" enctype="multipart/form-data">
            <label for=""><h2>Dodaj disciplino</h2></label>

            <label for="">Ime</label>
            <input type="text" id="title" name="title">

            <label for="">Tip</label>
            <select id="type" name="type">
                <option value="1">Tek</option>
                <option value="2">Tehnična disciplina</option>
            </select>


            <input type="submit" value="Dodaj">
        </form>
        </div>
        
        <div class="table-cont">
        <table>
            <tr>
                <th>Disciplina</th>
                <th>Tip</th>
                <th>št. Izpisa</th>
            </tr>                      
        <?php
        
            $newsQuery = "SELECT * FROM discipline";

            $newsResult = $conn->query($newsQuery);

            if($newsResult->num_rows > 0){

                while($row = $newsResult->fetch_assoc()){

                    ?>
                    
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['num_out']; ?></td>
                        </tr>   
                    
                    <?php

                }

            }

        ?>
        </table>
        </div>
    </div>

    <!-- SELECTIONS -->
    <div id="selekcije" class="contentDiv">
        <div>
        <form id="selekcije" action="submit-selection.php" method="POST" enctype="multipart/form-data">
            <label for=""><h2>Dodaj selekcijo</h2></label>

            <label for="">Naslov</label>
            <input type="text" id="title" name="title">

            <input type="submit" value="Dodaj">
        </form>
        </div>
        
        <div class="table-cont">
        <table>
            <tr>
                <th>Selekcija</th>
            </tr>                      
        <?php
        
            $newsQuery = "SELECT * FROM selection";

            $newsResult = $conn->query($newsQuery);

            if($newsResult->num_rows > 0){

                while($row = $newsResult->fetch_assoc()){

                    ?>
                    
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                        </tr>   
                    
                    <?php

                }

            }

        ?>
        </table>
        </div>
    </div>

    <!-- IMAGES -->
    <div id="slike" class="contentDiv">
        <div>
        <form id="slike" action="submit-image.php" method="POST" enctype="multipart/form-data">
            <label for=""><h2>Dodaj selekcijo</h2></label>

            <label for="">Slika</label>
            <input type="file" id="image" name="image">

            <label for="">Datoteka</label>
            <select id="folder" name="folder">
                <option value="galerija">Galerija</option>
                <option value="osebje">Osebe</option>
            </select>

            <input type="submit" value="Dodaj">
        </form>
        </div>
        
        <form action="submit-images.php" method="post" style="display: hidden;">
            <button type="submit">Scan repositories</button>
        </form>


        <div id="filegator" height="auto">
            <iframe src="../filegator/" style="width: 100%; height: 500px; border: none;"></iframe>
        </div>
    </div>

    <!-- ACCMOLISHMENTS -->
    <div id="dosezki" class="contentDiv">
        <?php

        $resultDiscipline = $conn->query("SELECT * FROM discipline");
        $resultPeople = $conn->query("SELECT * FROM people");
        $resultSelection = $conn->query("SELECT * FROM selection");

        ?>

        <form id="dosezki" action="submit-accom.php" method="POST" enctype="multipart/form-data">
            <label for=""><h2>Dodaj desežek</h2></label>

            <label for="">Vsebina</label>
            <textarea rows="5" cols="50" id="content" name="content"></textarea>

            <label for="">Tip dosežka</label>
            <label for="tablica">Tablica</label>
            <input type="checkbox" id="tablica" name="tablica" value="Tablica"><br>
            <label for="tablica">Klubski dosežek</label>
            <input type="checkbox" id="dosežek" name="dosežek" value="Tablica"><br>


            <label for="">Tip</label>
            <select id="type" name="type">
                <option value="1">Tek</option>
                <option value="2">Tehnična disciplina</option>
            </select>

            <label for="type">Oseba</label>
            <select id="type" name="type">
                <?php
                // Fetch the data from the database
                $resultPeople = $conn->query("SELECT * FROM people");

                if ($resultPeople->num_rows > 0) {
                    while ($row = $resultPeople->fetch_assoc()) {
                        // Display each person as an option in the dropdown
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . " " . $row['surname'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No people found</option>";
                }
                ?>
            </select>

            <input type="submit">
        </form>
        <div class="table-cont">
        <table>
            <tr>
                <th>Naslov</th>
                <th>Vsebina</th>
                <th class="fit">Čas objave</th>
                <th>Slika</th>
                <th>Prikazano</th>
            </tr>                      
        <?php
        
            $newsQuery = "SELECT * FROM news";

            $newsResult = $conn->query($newsQuery);

            if($newsResult->num_rows > 0){

                while($row = $newsResult->fetch_assoc()){

                    ?>
                    
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['content']; ?></td>
                            <td><?php echo $row['post_time']; ?></td>
                            <td><?php echo $row['id_image']; ?></td>
                            <td>
                                <?php 
                                    if ($row['shown'] == 1){
                                        ?> <input type="checkbox" checked> <?php
                                    }else if($row['shown'] == 0){
                                        ?> <input type="checkbox"> <?php
                                    }
                                ?>
                            </td>
                        </tr>   
                    
                    <?php

                }

            }

        ?>
        </table>
        </div>
    </div>
</main>

<script>
    // Initially hide all the content divs
    const contentDivs = document.querySelectorAll('.contentDiv');
    contentDivs.forEach(div => {
        div.style.display = 'none';
    });

    // Function to show the div associated with the clicked button
    function showDiv(divId) {
        // Hide all divs first
        contentDivs.forEach(div => {
            div.style.display = 'none';
        });

        // Show the clicked div
        const divToShow = document.getElementById(divId);
        if (divToShow) {
            divToShow.style.display = 'block';
        }
    }

    // Optional: You can set the default div to be visible on load (e.g., "Novice")
    showDiv('novice'); // Show the "Novice" div by default
</script>

<script>

$(document).ready(function() {
    // Initialize Select2 for the multi-select dropdown
    $('#type').select2({
        placeholder: "Select people",  // Placeholder text when no selection
        allowClear: true,              // Option to clear selections
    });
});


</script>

<script>
    const select = document.getElementById('select-options');
    const selectedValuesContainer = document.getElementById('selected-values');

    select.addEventListener('change', () => {
      const selectedValue = select.value;

      // Check if the value is already displayed
      if (document.querySelector(`[data-value="${selectedValue}"]`)) {
        alert('This value is already added!');
        return;
      }

      // Create a div for the selected item
      const selectedItem = document.createElement('div');
      selectedItem.classList.add('selected-item');
      selectedItem.setAttribute('data-value', selectedValue);

      // Add the selected value
      const textNode = document.createTextNode(selectedValue);
      selectedItem.appendChild(textNode);

      // Create a delete button
      const deleteBtn = document.createElement('button');
      deleteBtn.classList.add('delete-btn');
      deleteBtn.textContent = 'Delete';
      deleteBtn.addEventListener('click', () => {
        selectedValuesContainer.removeChild(selectedItem);
      });

      // Append the delete button to the selected item
      selectedItem.appendChild(deleteBtn);

      // Append the selected item to the container
      selectedValuesContainer.appendChild(selectedItem);
    });
  </script>

<?php include"footer.php" ?>
</body>
</html>
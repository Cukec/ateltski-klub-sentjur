<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atleti</title>

    <link rel="stylesheet" href="styles/atleti.css">

    <style>
  table, th, td {
    border: 1px solid black;
    visibility: visible;
  }
</style>
</head>
<body>
    <?php include "navigation.php"; include "config.php";?>

    <main>
        <?php 
        // Database connection
        // Assuming you have a $conn variable that connects to your database

        // Define how many results per page
        $resultsPerPage = 10;

        // Find out the current page number
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        // Determine the starting limit for the results
        $offset = ($page - 1) * $resultsPerPage;

        // Query to count total profiles
        $totalQuery = "SELECT COUNT(*) AS total FROM people p JOIN athlete a ON p.id = a.id_people WHERE a.active = 1";
        $totalResult = $conn->query($totalQuery);
        $totalRows = $totalResult->fetch_assoc()['total'];

        // Calculate the total number of pages
        $totalPages = ceil($totalRows / $resultsPerPage);

        // Query to get the profiles for the current page
        $query = "SELECT p.id, p.name, p.surname, p.gender, p.date_of_birth, a.id AS athlete_id 
                FROM people p 
                JOIN athlete a ON p.id = a.id_people 
                WHERE a.active = 1
                ORDER BY p.surname ASC 
                LIMIT $resultsPerPage OFFSET $offset";
        $result = $conn->query($query);
        ?>
        <section class="atleti-info">
            <div class="description-main">
                <h1>Delo z atleti</h1>
                <hr>
                <p>V AK Šentjur stavimo veliko na delo z mladimi, zato so v večini naši atleti in atletinje člani mlajših selekcij. Naš osnovni in vedno prisoten cilj je s trdim delom ter skrbno načrtovanimi treningi vzgajati tekmovalce od mladih nog, da bodo nekoč morda nekateri med njimi sposobni v slovenskem prostoru in širše posegati po najvišjih mestih.</p>
            </div>
            <div class="atletska-sola">
                <a href="treningi.php"><img src="../assets/logo-atletska-sola.png" alt="logo-atletska-sola"></a>
            </div>
        </section>

        <?php 
        
        $vse_discipline_query = "SELECT * FROM discipline";
        $vse_discipline_result = $conn->query($vse_discipline_query);

        $vse_selekcije_query = "SELECT * FROM selection";
        $vse_selekcije_result = $conn->query($vse_selekcije_query);

        ?>

        <div class="nav-atleti" id="past-events-section">
            <ul>
                <li><button id="active-athletes" class="athlete-toggle" data-type="active">Aktivni</button></li>
                <li><button id="ex-athletes" class="athlete-toggle" data-type="ex-athlete">Nekdanji</button></li>
                <li><a href="dosezki-atleti.php"><button id="club-acc" class="acc-toggle" data-type="club-acc">Dosežki</button></a></li>
                <li><a href="tablice-atleti.php"><button id="tables" class="acc-toggle" data-type="table">Tablice</button></a></li>
            </ul>
        </div>

        <!-- Tabela atletov -->

        <div class="display-table">
            <table>
                <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Priimek</th>
                        <th>Datum rojstva</th>
                        <th>Spol</th>
                        <th>Discipline</th>
                    </tr>
                </thead>
                <tbody id="athletes-body">
                    <!-- Athlete rows will be inserted here -->
                </tbody>
            </table>
            <div class="pagination">
                <button id="prev-page"><</button>
                <div id="current-page"><p>1</p></div>
                <button id="next-page">></button>
            </div>
        </div>


        <!-- Sql querry-ji za dosežke in tablice -->

        <!-- <div class="acc-filters">
            <ul>
                <li>
                    <label for="discipline-filter">Disciplina:</label>
                    <select id="discipline-filter" name="discipline">
                        <option value="">Izberite disciplino</option>
                        <?php 
                        if ($vse_discipline_result && $vse_discipline_result->num_rows > 0) {
                            while ($discipline = $vse_discipline_result->fetch_assoc()) {
                                echo "<option value='{$discipline['id']}'>{$discipline['title']}</option>";
                            }
                        } else {
                            echo "<option value=''>No disciplines found</option>";
                        }
                        ?>
                    </select>
                </li>

                <li>
                    <label for="selection-filter">Selekcija:</label>
                    <select id="selection-filter" name="selection">
                        <option value="">Izberite selekcijo</option>
                        <?php 
                        if ($vse_selekcije_result && $vse_selekcije_result->num_rows > 0) {
                            while ($selection = $vse_selekcije_result->fetch_assoc()) {
                                echo "<option value='{$selection['id']}'>{$selection['title']}</option>";
                            }
                        } else {
                            echo "<option value=''>No selections found</option>";
                        }
                        ?>
                    </select>
                </li>
            </ul>
        </div> -->

        <!--<div class="display-accomplishments">
            <table id="tablice">
                <thead>
                    <tr>
                        <th>Rezultat</th>
                        <th>Atlet</th>
                        <th>Leto</th>
                        <th>Kraj</th>
                    </tr>
                </thead>
                <tbody id="tables-body">
                    --comment Data from fetch-accomplishments.php will populate here comment--
                </tbody>
            </table>
        </div> -->
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentPage = 1;
                const resultsPerPage = 10;
                let athleteType = 'active'; // Default to active athletes

                // Function to fetch athletes data and update the table
                function loadAthletes(page) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', `fetch-athletes.php?page=${page}&type=${athleteType}`, true);
                    xhr.onload = function() {
                        if (this.status === 200) {
                            const data = JSON.parse(this.responseText);
                            const athletes = data.athletes;
                            const totalPages = data.totalPages;

                            // Update the table body
                            const tableBody = document.getElementById('athletes-body');
                            tableBody.innerHTML = ''; // Clear current rows
                            
                            // Add each athlete row to the table
                            athletes.forEach(athlete => {
                                const genderDisplay = athlete.gender === 'm' ? 'Moški' : 'Ženski';  // Adjust gender label
                                const row = `<tr id="normal" onClick="window.location.href='info-atlet.php?id=${athlete.id}'">
                                    <td>${athlete.name}</td>
                                    <td>${athlete.surname}</td>
                                    <td>${athlete.dob}</td>
                                    <td>${genderDisplay}</td>
                                    <td>${athlete.disciplines}</td>
                                </tr>`;
                                tableBody.insertAdjacentHTML('beforeend', row);  // Add the row to the table
                            });

                            // Calculate how many empty rows are needed
                            const rowsToFill = resultsPerPage - athletes.length;

                            // Add empty rows if necessary
                            for (let i = 0; i < rowsToFill; i++) {
                                const emptyRow = `<tr>
                                    <td colspan="5" style="text-align: center;">/</td>
                                </tr>`;
                                tableBody.insertAdjacentHTML('beforeend', emptyRow);
                            }

                            // Set table opacity to 1 after data is loaded
                            document.querySelector('table').style.opacity = 1;

                            // Update current page display
                            document.getElementById('current-page').textContent = `${page}`;
                            currentPage = page;

                            // Handle pagination visibility and pointer events
                            const prevPageButton = document.getElementById('prev-page');
                            const nextPageButton = document.getElementById('next-page');

                            if (page === 1) {
                                prevPageButton.style.opacity = '0';
                                prevPageButton.style.pointerEvents = 'none';
                            } else {
                                prevPageButton.style.opacity = '1';
                                prevPageButton.style.pointerEvents = 'auto';
                            }

                            if (page >= totalPages) {
                                nextPageButton.style.opacity = '0';
                                nextPageButton.style.pointerEvents = 'none';
                            } else {
                                nextPageButton.style.opacity = '1';
                                nextPageButton.style.pointerEvents = 'auto';
                            }
                        }
                    };
                    xhr.send();
                }

                // Event listeners for pagination
                document.getElementById('prev-page').addEventListener('click', function() {
                    if (currentPage > 1) loadAthletes(currentPage - 1);
                });
                document.getElementById('next-page').addEventListener('click', function() {
                    loadAthletes(currentPage + 1);
                });

                // Event listeners for athlete type buttons
                const athleteButtons = document.querySelectorAll('.athlete-toggle');
                athleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        athleteType = this.getAttribute('data-type'); // Get the type from the button
                        currentPage = 1; // Reset to the first page
                        loadAthletes(currentPage); // Load athletes of the selected type
                    });
                });

                // Load the first page initially
                loadAthletes(1);
            });
        </script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to fetch and display accomplishments based on selected filters
            function loadAccomplishments() {
                const disciplineId = document.getElementById('discipline-filter').value;
                const selectionId = document.getElementById('selection-filter').value;
                console.log(`Fetching accomplishments for discipline ${disciplineId} and selection ${selectionId}`);

                // Construct the URL with query parameters for the selected filters
                const url = `fetch-accomplishments.php?discipline=${disciplineId}&selection=${selectionId}`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Accomplishments data:", data);

                        const tableBody = document.getElementById('tables-body');
                        tableBody.innerHTML = ''; // Clear existing rows

                        if (data.accomplishments.length > 0) {
                            data.accomplishments.forEach(item => {
                                const row = `
                                    <tr>
                                        <td>${item.result}</td>
                                        <td>${item.name} ${item.surname}</td>
                                        <td>${item.date}</td>
                                        <td>${item.location}</td>
                                    </tr>
                                `;
                                tableBody.insertAdjacentHTML('beforeend', row);
                            });
                        } else {
                            tableBody.innerHTML = `<tr><td colspan="4" style="text-align:center;">No accomplishments found</td></tr>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading accomplishments:', error);
                    });
            }

            // Add event listeners for filter changes to update the table dynamically
            document.getElementById('discipline-filter').addEventListener('change', loadAccomplishments);
            document.getElementById('selection-filter').addEventListener('change', loadAccomplishments);

            // Initial load of accomplishments when page is first loaded
            loadAccomplishments();
        });


        </script>

    </main>

    <?php include "footer.php"; ?>

</body>
</html>
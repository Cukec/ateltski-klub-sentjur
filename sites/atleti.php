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
    <?php include"navigation.php"; include"config.php";?>

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

    <section class="subtitle-middle">
        <div class="description">
            <h1>Delo z atleti</h1>
            <hr>
            <p>
            V AK Šentjur stavimo veliko na delo z mladimi, zato so v večini naši atleti in atletinje člani mlajših selekcij. Naš osnovni in vedno prisoten cilj je s trdim delom ter skrbno načrtovanimi treningi vzgajati tekmovalce od mladih nog, da bodo nekoč morda nekateri med njimi sposobni v slovenskem prostoru in širše posegati po najvišjih mestih.</p>
        </div>
    </section>

    <div class="nav-atleti" id="past-events-section">
        <ul>
            <li><button id="active-athletes" class="athlete-toggle" data-type="active">Aktivni</button></li>
            <li><button id="ex-athletes" class="athlete-toggle" data-type="ex-athlete">Nekdanji</button></li>
        </ul>
    </div>

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
    

</div>

    <script>
        const button = document.querySelector('.nav-atleti button');

        button.addEventListener('mouseover', () => {
            button.style.transform = 'scale(1.1)';
        });

        button.addEventListener('mouseout', () => {
            button.style.transform = 'scale(1.2)';
            setTimeout(() => {
                button.style.transform = 'scale(1)'; // Reset to original scale
            }, 300); // Match the duration of the transition
        });
    </script>

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
                            const row = `<tr onClick="window.location.href='info-atlet.php?id=${athlete.id}'">
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

                        // Update current page
                        document.getElementById('current-page').textContent = `${page}`;
                        currentPage = page;

                        // Handle pagination visibility
                        document.getElementById('prev-page').style.display = page > 1 ? 'inline-block' : 'none';
                        document.getElementById('next-page').style.display = page < totalPages ? 'inline-block' : 'none';
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

    <?php include "footer.php"; ?>

</body>
</html>
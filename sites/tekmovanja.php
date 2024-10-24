<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dogodki</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <link rel="stylesheet" href="styles/tekmovanja.css"/>
</head>
<body>

    <?php include "navigation.php"; include "config.php"; ?>
    
    <section class="dogodki-info">
        <div class="description-main">
            <h1>Dogodki in tekmovanja</h1>
            <hr>
            <p>Prihajajoči dogodki in tekmovanja so barvno označeni na koledarju. S klikom na želeni datum se vam bo prikazal urnik tistega dne.</p>
        </div>
        <div id="calendar"></div>
    </section>

    <div class="nav-dogodki" id="past-events-section"> <!-- Added ID here -->
        <ul>
            <li><p>Prihajajoči</p></li>
            <li><p>Pretekli</p></li>
        </ul>
    </div>

    <section class="subtitle">
        <div class="description">
            <h1>Prihajajoči dogodki</h1>
            <hr><br>
            <p>Prikazani dogodki se bodo odvijali v bližnji prihodnosti.</p>
        </div>
        <div>
            <div class="upcoming-events" id="future-events-container">
                <div class="novice">
                    <?php 
                    // Define how many results per page
                    $resultsPerPage = 5;

                    // Find out the current page number
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($page < 1) $page = 1;

                    // Determine the starting limit for the results
                    $offset = ($page - 1) * $resultsPerPage;

                    // Query to count total events that happened before today
                    $totalQuery = "SELECT COUNT(*) AS total FROM events WHERE date_start > CURDATE()";
                    $totalResult = $conn->query($totalQuery);
                    $totalRows = $totalResult->fetch_assoc()['total'];

                    // Calculate the total number of pages
                    $totalPages = ceil($totalRows / $resultsPerPage);

                    // Query to get the events for the current page, most recent first
                    $query = "SELECT * FROM events WHERE date_start < CURDATE() ORDER BY date_start DESC LIMIT $resultsPerPage OFFSET $offset;";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Remove the year and semicolon from the title
                            $title = preg_replace('/^\d{4};/', '', $row['title']);
                            
                            // Ensure correct character encoding is handled
                            $title = html_entity_decode($title, ENT_QUOTES, 'UTF-8'); // Decode any HTML entities
                            $cleanContent = strip_tags($row['content']);
                            $contentPreview = substr($cleanContent, 0, 50) . '...';
                            
                            // Assume you have an 'id' field in your 'events' table to uniquely identify each event
                            $eventId = $row['id'];
                            ?>
                            <div class="novica">
                                <!-- Display title and date next to each other -->
                                <div style="display: flex; flex-direction: horizontal;">
                                    <!-- Make title clickable and redirect to info-dogodek.php with event id as a query parameter -->
                                    <h2>
                                        <a href="info-dogodek.php?id=<?= $eventId; ?>" style="text-decoration: none; color: inherit;">
                                            <?= $title; ?>
                                        </a>
                                    </h2>
                                    <h2 style="color: #dedede; margin-left: 1vw;"> <?= htmlspecialchars($row['date_start']); ?> </h2>
                                </div>
                                <p> <?= htmlspecialchars($contentPreview); ?> </p>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No news available.";
                    }
                    
                    
                    ?>
                </div>
            </div>
        </div>
    </section>
    
    
    <section class="past-events-content">
        <div class="subtitle-section">
            <div class="description">
                <h1>Pretekli dogodki</h1>
                <hr>
                <p>Skozi leta smo v AK Šentjur priredili in se udeležili mnogo tekmovanj in dogodkov. Spodaj lahko prebrskate po spominih in dosežkih iz njih.</p>
                <div class="filter-section">
                    <label for="year-select">Year:</label>
                    <select id="year-select" onchange="filterEvents()">
                        <!-- Year options will be dynamically populated -->
                    </select>

                    <label for="month-select">Month:</label>
                    <select id="month-select" onchange="filterEvents()">
                        <option value="all">All</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="content-section">
            <div class="past-events" id="events-container">
                <!-- Events dynamically inserted -->
            </div>

            <div class="pagination">
                <button id="prev-page" style="display: none;"><</button>
                <div id="current-page">1</div>
                <button id="next-page">></button>
            </div>
        </div>
    </section>

    

    

    

    
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#calendar", {
                inline: true,
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    console.log("Selected date:", dateStr);
                },
                onReady: function(selectedDates, dateStr, instance) {
                    console.log("Calendar is ready");
                }
            });

            // Initial page load for current year past events
            const currentYear = new Date().getFullYear();
            const yearSelect = document.getElementById('year-select');

            // Populate year dropdown with options from 2013 to the current year
            for (let year = currentYear; year >= 2013; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.text = year;
                yearSelect.add(option);
            }

            // Set the default selected year to the current year
            yearSelect.value = currentYear;

            // Load past events by default
            filterEvents(1); // Fetch past events on page load

            // Event listener for the month dropdown
            document.getElementById('month-select').addEventListener('change', () => {
                filterEvents(1); // Reload events on month change
            });

            // Event listener for the year dropdown
            yearSelect.addEventListener('change', () => {
                filterEvents(1); // Reload events on year change
            });
        });

        function filterEvents(page = 1) {
            const year = document.getElementById('year-select').value;
            const month = document.getElementById('month-select').value;

            // Send AJAX request to fetch filtered events with pagination
            fetch(`fetch-past-events.php?year=${year}&month=${month}&page=${page}`)
                .then(response => response.json())
                .then(data => {
                    displayEvents(data.events); // Display events
                    updatePagination(data.totalPages, page); // Update pagination controls
                });
        }

        function displayEvents(events) {
            const eventsContainer = document.getElementById('events-container');
            eventsContainer.innerHTML = ''; // Clear previous events

            events.forEach(event => {
                const eventDiv = document.createElement('div');
                eventDiv.classList.add('dogodek-past');
                eventDiv.innerHTML = `
                    <div style="display: flex; flex-direction: horizontal;">
                        <h2>
                            <a href="info-dogodek.php?id=${event.id}" style="text-decoration: none; color: black;">
                                ${event.title}
                            </a>
                        </h2>
                        <h2 style="color: #dedede; margin-left: 1vw;">${event.date_start}</h2>
                    </div>
                    <p>${event.contentPreview}</p>
                `;
                eventsContainer.appendChild(eventDiv);
            });
        }

        function updatePagination(totalPages, currentPage) {
            const paginationContainer = document.querySelector('.pagination');
            paginationContainer.innerHTML = ''; // Clear previous pagination

            if (currentPage > 1) {
                paginationContainer.innerHTML += `<button onclick="filterEvents(${currentPage - 1})">&lt;</button>`;
            }

            paginationContainer.innerHTML += `<span class="page-number">${currentPage}</span>`;

            if (currentPage < totalPages) {
                paginationContainer.innerHTML += `<button onclick="filterEvents(${currentPage + 1})">&gt;</button>`;
            }
        }
    </script>


    <?php include "footer.php"; ?>
</body>
</html>

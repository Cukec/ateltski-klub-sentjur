<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/atleti-dosezki.css">
    <title>Dosezki</title>
</head>
<body>

    <?php include "navigation.php"; include "config.php";?>

    <div class="year-filter">
        <label for="year-select">Izberi leto:</label>
        <select id="year-select">
            <option value="all">Vsa leta</option>
        </select>
    </div>

    <main>  
        <div class="grid" id="accomplishment-grid"></div>

        <div id="acc-pagination" class="pagination"></div>

        <div class="go-back">
            <a href="atleti.php">nazaj ↶</a>
        </div>

    </main>

    <?php include('footer.php'); ?>
</body>

<!-- skripta za pagination -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('accomplishment-grid');
    const yearSelect = document.getElementById('year-select');

    function fetchYears() {
        fetch('get-years.php')
            .then(res => res.json())
            .then(years => {
                years.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    yearSelect.appendChild(option);
                });
            });
    }

    function fetchAccomplishments(year) {
        const url = year === 'all' ? 'load-achivements.php' : `load-achivements.php?year=${year}`;
        fetch(url)
            .then(res => res.text())
            .then(html => {
                grid.innerHTML = html;
            })
            .catch(err => {
                console.error("Napaka pri pridobivanju dosežkov:", err);
            });
    }

    // Load years then load default
    fetchYears();
    fetchAccomplishments('all');

    yearSelect.addEventListener('change', () => {
        fetchAccomplishments(yearSelect.value);
    });
});
</script>



</html>
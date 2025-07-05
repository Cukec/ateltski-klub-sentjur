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
    const pagination = document.getElementById('acc-pagination');
    const perPage = 8;
    let currentPage = 1;
    let totalPages = 1;
    const maxButtons = 7; // max število gumbov v paginaciji

    function fetchAccomplishments(page) {
        fetch(`load-achivements.php?page=${page}`)
            .then(res => res.text())
            .then(html => {
                grid.innerHTML = html;
                currentPage = page;
                updatePagination();
            })
            .catch(err => {
                console.error("Napaka pri pridobivanju dosežkov:", err);
            });
    }

    function updatePagination() {
        pagination.innerHTML = '';

        function addPageButton(i) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.classList.add('page-btn');
            if (i === currentPage) btn.classList.add('active');
            btn.addEventListener('click', () => fetchAccomplishments(i));
            pagination.appendChild(btn);
        }

        function addEllipsis() {
            const ellipsis = document.createElement('span');
            ellipsis.textContent = '...';
            ellipsis.classList.add('ellipsis');
            pagination.appendChild(ellipsis);
        }

        if (totalPages <= maxButtons) {
            for (let i = 1; i <= totalPages; i++) {
                addPageButton(i);
            }
        } else {
            addPageButton(1);

            let left = currentPage - 2;
            let right = currentPage + 2;

            if (left < 2) {
                right += 2 - left;
                left = 2;
            }
            if (right > totalPages - 1) {
                left -= right - (totalPages - 1);
                right = totalPages - 1;
                if (left < 2) left = 2;
            }

            if (left > 2) {
                addEllipsis();
            }

            for (let i = left; i <= right; i++) {
                addPageButton(i);
            }

            if (right < totalPages - 1) {
                addEllipsis();
            }

            addPageButton(totalPages);
        }
    }

    // Pridobi skupno število dosežkov in nastavi totalPages, nato naloži prvo stran
    fetch('count-accomplishments.php')
        .then(res => res.json())
        .then(data => {
            totalPages = Math.ceil(data.total / perPage);
            fetchAccomplishments(1);
        });
});
</script>


</html>
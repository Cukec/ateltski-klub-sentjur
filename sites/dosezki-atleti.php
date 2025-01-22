<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/atleti.css">
    <title>Dosezki</title>
</head>
<body>

    <?php include "navigation.php"; include "config.php";?>

    <main>

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

        <div class="nav-atleti" id="past-events-section">
            <ul>
                <li><button id="active-athletes" class="athlete-toggle" data-type="active">Aktivni</button></li>
                <li><button id="ex-athletes" class="athlete-toggle" data-type="ex-athlete">Nekdanji</button></li>
                <li><a href="dosezki-atleti.php"><button id="club-acc" class="acc-toggle" data-type="club-acc">Dosežki</button></a></li>
                <li><a href="tablice-atleti.php"><button id="tables" class="acc-toggle" data-type="table">Tablice</button></a></li>
            </ul>
        </div>

        <div class="display-accomplishments">
            <table>
                <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Priimek</th>
                        <th>Rezultat</th>
                    </tr>
                </thead>
                <tbody id="tables-body">

                </tbody>
            </table>
        </div>
    </main>

    <?php include "footer.php"; ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            fetch('fetch-accomplishments.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tables-body');
                    tbody.innerHTML = '';
                    data.accomplishments.forEach(accomplishment => {
                        const row = `
                            <tr>
                                <td>${accomplishment.name}</td>
                                <td>${accomplishment.surname}</td>
                                <td>${accomplishment.result}</td>
                            </tr>`;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>
</body>
</html>
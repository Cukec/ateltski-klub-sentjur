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
                        <th>Rezultat</th>
                        <th>Atlet</th>
                        <th>Leto</th>
                        <th>Kraj</th>
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
            const tbody = document.getElementById("tables-body");

            // Fetch data from the server
            fetch("fetch-accomplishments.php")
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Failed to fetch data from the server.");
                    }
                    return response.json();
                })
                .then(data => {
                    const accomplishments = data.accomplishments;

                    // Clear the table body
                    tbody.innerHTML = "";

                    // Check if there are accomplishments
                    if (accomplishments.length === 0) {
                        // Display a friendly message if no data is available
                        tbody.innerHTML = `<tr><td colspan="4">Trenutno ni dosežkov za prikaz.</td></tr>`;
                        return;
                    }

                    // Populate the table with fetched data
                    accomplishments.forEach(item => {
                        const row = document.createElement("tr");

                        row.innerHTML = `
                            <td>${item.result || "N/A"}</td>
                            <td>${item.name} ${item.surname}</td>
                            <td>${item.date}</td>
                            <td>${item.location || "N/A"}</td>
                        `;

                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error("Error:", error);
                    tbody.innerHTML = `<tr><td colspan="4">Prišlo je do napake pri nalaganju podatkov.</td></tr>`;
                });
        });
    </script>
</body>
</html>
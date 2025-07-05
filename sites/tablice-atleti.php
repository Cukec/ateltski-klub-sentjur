<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/tablice-atleti.css">
    <title>Dosezki</title>
</head>
<body>

    <?php include "navigation.php"; include "config.php";?>

    <main>
        <div class="go-back">
            <a href="atleti.php">nazaj ↶</a>
        </div>

        <div class="filter-container">
        <label for="discipline">Disciplina:</label>
        <select id="discipline">
            <option value="">Vse discipline</option>
        </select><br>

        <label for="selection">Selekcija:</label>
        <select id="selection">
            <option value="">Vse selekcije</option>
        </select>
        </div>
        
        <div class="loader-wrapper">
            <div id="loader" class="loader" style="display: none;"></div>
        </div>

        <div id="results-container"></div>

        <button id="scrollTopBtn" title="Na vrh">↑</button>

    </main>
</body>

<!-- skripta za filtracijo -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const disciplineSelect = document.getElementById('discipline');
    const selectionSelect = document.getElementById('selection');
    const container = document.getElementById('results-container');

    function fetchTabularResults() {
        const discipline = disciplineSelect.value;
        const selection = selectionSelect.value;

        const params = new URLSearchParams();
        if (discipline) params.append('discipline', discipline);
        if (selection) params.append('selection', selection);

        fetch(`load-tabular-results.php?${params.toString()}`)
            .then(res => res.text())
            .then(html => {
                container.innerHTML = html;
            })
            .catch(err => {
                container.innerHTML = '<p>Napaka pri nalaganju rezultatov.</p>';
                console.error(err);
            });
    }

    disciplineSelect.addEventListener('change', fetchTabularResults);
    selectionSelect.addEventListener('change', fetchTabularResults);

    // Prvo nalaganje
    fetchTabularResults();
});
</script>

<!-- skripta za nalaganje discipline/selekcij -->
<script>
function loadFilters() {
  // Naloži discipline
  fetch('load-disciplines.php')
    .then(res => res.json())
    .then(data => {
      const disciplineSelect = document.getElementById('discipline');
      disciplineSelect.innerHTML = '<option value="">Izberi disciplino</option>';
      data.forEach(d => {
        const option = document.createElement('option');
        option.value = d.id;
        option.textContent = d.title;
        disciplineSelect.appendChild(option);
      });
    });

  // Naloži selekcije
  fetch('load-selections.php')
    .then(res => res.json())
    .then(data => {
      const selectionSelect = document.getElementById('selection');
      selectionSelect.innerHTML = '<option value="">Izberi selekcijo</option>';
      data.forEach(s => {
        const option = document.createElement('option');
        option.value = s.id;
        option.textContent = s.title;
        selectionSelect.appendChild(option);
      });
    });
}

document.addEventListener('DOMContentLoaded', () => {
  loadFilters();          // Najprej naložiš možnosti
  loadResults();          // Nato naložiš vse podatke

  // Dogodki za filtracijo
  document.getElementById('discipline').addEventListener('change', () => {
    const sel = document.getElementById('selection').value;
    const dis = document.getElementById('discipline').value;
    loadResults(sel, dis);
  });

  document.getElementById('selection').addEventListener('change', () => {
    const sel = document.getElementById('selection').value;
    const dis = document.getElementById('discipline').value;
    loadResults(sel, dis);
  });
});


function loadResults(selection = '', discipline = '') {
  const container = document.getElementById("results-container");
  const loader = document.getElementById("loader");

  loader.style.display = "flex";
  container.innerHTML = ''; // Počisti prejšnje vsebine

  const params = new URLSearchParams();
  if (selection) params.append("selection", selection);
  if (discipline) params.append("discipline", discipline);

  fetch(`load-tabular-results.php?${params.toString()}`)
    .then(res => res.text())
    .then(html => {
      loader.style.display = "none";
      container.innerHTML = html;
    })
    .catch(err => {
      loader.style.display = "none";
      container.innerHTML = "<p>Napaka pri nalaganju rezultatov.</p>";
      console.error("Napaka:", err);
    });
}

</script>

<!-- skripta za gumb na vrh -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const scrollBtn = document.getElementById('scrollTopBtn');

  // Pokaži gumb, ko uporabnik skrola
  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      scrollBtn.classList.add('show');
    } else {
      scrollBtn.classList.remove('show');
    }
  });

  // Ob kliku se premakni na vrh strani
  scrollBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
});
</script>


</html>
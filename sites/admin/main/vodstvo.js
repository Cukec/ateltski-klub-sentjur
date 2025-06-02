function fetchTeam() {
    fetch('get-team.php')
      .then(res => res.json())
      .then(data => {
        const tbody = document.getElementById('teamBody');
        tbody.innerHTML = '';
        data.forEach(member => {
          tbody.innerHTML += `
            <tr data-id="${member.id}">
              <td contenteditable onblur="updateField(${member.id}, 'name', this.innerText)">${member.name}</td>
              <td contenteditable onblur="updateField(${member.id}, 'surname', this.innerText)">${member.surname}</td>
              <td contenteditable onblur="updateField(${member.id}, 'function', this.innerText)">${member.function}</td>
              <td>${member.display_order}</td>
              <td>
                <button onclick="moveUp(${member.id})">🔼</button>
                <button onclick="moveDown(${member.id})">🔽</button>
                <button onclick="deleteMember(${member.id})"> 🗑️</button>
              </td>
            </tr>`;
        });
    });
}
  
function updateField(id, field, value) {
    fetch('update-member.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, field, value })
    }).then(() => fetchTeam());
}
  
function addNewMember() {
    fetch('add-member.php', { method: 'POST' }).then(() => fetchTeam());
}
  
function deleteMember(id) {
    fetch('delete-member.php?id=' + id, { method: 'GET' }).then(() => fetchTeam());
}
  
function moveUp(id) {
    fetch('move-member.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, direction: 'up' })
    }).then(() => fetchTeam());
}
  
function moveDown(id) {
    fetch('move-member.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, direction: 'down' })
    }).then(() => fetchTeam());
}
  
document.addEventListener('DOMContentLoaded', fetchTeam);

function submitAddForm(event) {
  event.preventDefault();
  const form = event.target;

  const data = {
    name: form.name.value.trim(),
    surname: form.surname.value.trim(),
    function: form.function.value.trim()
  };

  // Simple validation
  if (!data.name || !data.surname || !data.function) return;

  fetch('add-member.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  })
  .then(response => {
    if (!response.ok) throw new Error("Failed to add member");
    return response.text(); // or .json() if you're returning JSON
  })
  .then(() => {
    form.reset();      // Clear form inputs
    fetchTeam();       // Refresh the list
  })
  .catch(error => {
    alert("Error: " + error.message);
  });
}

  
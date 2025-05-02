// Grab the drop zone
const dropZone = document.getElementById('drop-zone');

// When files are dropped
dropZone.addEventListener('drop', (event) => {
    event.preventDefault();
    const files = event.dataTransfer.files;

    // Folder name - dynamically set or can be hardcoded for testing
    const folderName = "my-upload-folder"; // You can dynamically set this if needed

    // Create FormData to send to the server
    const formData = new FormData();

    // Append folder name
    formData.append("folderName", folderName);

    // Append all dropped files
    for (let i = 0; i < files.length; i++) {
        formData.append('images[]', files[i]);
    }

    // Send the request to the server
    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Handle success or show message
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Prevent the default behavior (prevent page refresh when files are dragged over)
dropZone.addEventListener('dragover', (event) => {
    event.preventDefault();
});

// Optional: To show visual feedback when dragging files over the drop zone
dropZone.addEventListener('dragenter', () => {
    dropZone.style.borderColor = 'green'; // Change border to green on enter
});

dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = '#ccc'; // Revert to original color when leaving
});

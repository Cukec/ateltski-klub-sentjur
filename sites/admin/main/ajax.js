// Select the file input and the file list container
const fileInput = document.getElementById('uploadFile');
const fileListContainer = document.getElementById('files');

// Function to handle the file upload
function uploadFile() {
    const files = fileInput.files;
    if (files.length > 0) {
        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        // Optional: If you're working with directories, you can specify a path here
        formData.append('path', currentPath);  // Set a current directory path if needed

        // Make the AJAX request to upload the files
        fetch('file-api.php?action=upload', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Files uploaded successfully');
                loadFiles(currentPath);  // Reload the file list after successful upload
            } else {
                console.error('Upload failed:', data.error);
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
        });
    }
}

// Function to load the files (called after upload or on page load)
function loadFiles(path) {
    fetch('file-api.php?action=loadFiles&path=' + path)
        .then(response => response.json())
        .then(files => {
            fileListContainer.innerHTML = '';  // Clear the current file list
            files.forEach(file => {
                const li = document.createElement('li');
                li.textContent = file;
                fileListContainer.appendChild(li);
            });
        })
        .catch(error => {
            console.error('Error loading files:', error);
        });
}

// Load files on page load
document.addEventListener('DOMContentLoaded', () => {
    loadFiles(currentPath);  // Load files for the current directory
});

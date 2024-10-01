// Function to create the file tree structure
function createFileTree(treeData, parentElement) {
    const ul = document.createElement('ul');

    treeData.forEach(item => {
        const li = document.createElement('li');
        
        if (item.type === 'directory') {
            li.textContent = '[Dir] ' + item.name;
            li.classList.add('directory');

            // Add click event to select this folder
            li.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent event bubbling
                
                // Clear any previous selection
                const previouslySelected = document.querySelector('.selected');
                if (previouslySelected) {
                    previouslySelected.classList.remove('selected');
                }

                // Highlight the selected folder
                li.classList.add('selected');

                // Set the selected folder path in the hidden input
                document.getElementById('selectedFolder').value = item.path;
            });

            // Recursively create sub-trees (for child folders if any)
            if (item.children && item.children.length > 0) {
                const children = createFileTree(item.children, li);
                li.appendChild(children);
                children.style.display = 'none';  // Start hidden

                // Toggle visibility of subfolders
                li.addEventListener('dblclick', function(e) {
                    e.stopPropagation();
                    children.style.display = children.style.display === 'none' ? 'block' : 'none';
                });
            }
        } else {
            li.textContent = item.name;
            li.classList.add('file');
        }

        ul.appendChild(li);
    });

    parentElement.appendChild(ul);
    return ul;
}

// Fetch the file tree JSON from the server (assuming file-tree.php returns this structure)
fetch('file-tree.php')
    .then(response => response.json())
    .then(data => {
        const fileTreeContainer = document.getElementById('fileTree');
        createFileTree(data, fileTreeContainer);
    })
    .catch(error => console.error('Error fetching file tree:', error));

// Function to create the file tree structure
function createFileTree(treeData, parentElement) {
    const ul = document.createElement('ul');

    treeData.forEach(item => {
        const li = document.createElement('li');
        
        if (item.type === 'directory') {
            li.textContent = '[Dir] ' + item.name;
            li.classList.add('directory');

            // Recursively create sub-trees
            const children = createFileTree(item.children, li);
            li.appendChild(children);

            // Add click event to toggle visibility of subfolders
            li.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent event bubbling
                children.style.display = children.style.display === 'none' ? 'block' : 'none';
            });

            children.style.display = 'none';  // Start hidden
        } else {
            li.textContent = item.name;
            li.classList.add('file');
        }

        ul.appendChild(li);
    });

    parentElement.appendChild(ul);
    return ul;
}

// Fetch the file tree JSON from the server
fetch('file-tree.php')
    .then(response => response.json())
    .then(data => {
        const fileTreeContainer = document.getElementById('fileTree');
        createFileTree(data, fileTreeContainer);
    })
    .catch(error => console.error('Error fetching file tree:', error));

document.addEventListener("DOMContentLoaded", () => {
    const loadMoreButton = document.getElementById("load-more");
    const galleryContainer = document.querySelector(".gallery-container");
    const remainingFoldersInput = document.getElementById("remaining-folders");
    let remainingFolders = JSON.parse(remainingFoldersInput.value);

    // Load more button click handler
    loadMoreButton.addEventListener("click", () => {
        if (remainingFolders.length === 0) {
            loadMoreButton.style.display = "none";
            return;
        }

        const newFolders = remainingFolders.splice(0, 5); // Load 5 more folders
        remainingFoldersInput.value = JSON.stringify(remainingFolders);

        newFolders.forEach((folderPath, galleryId) => {
            const folderName = folderPath.split("/").pop();

            // Create the folder div for the new gallery
            const folderDiv = document.createElement("div");
            folderDiv.classList.add("gallery-folder");
            folderDiv.setAttribute("data-gallery-id", galleryId);
            folderDiv.setAttribute("data-folder-path", folderPath);

            // Create and append folder title
            const title = document.createElement("h2");
            title.classList.add("folder-title");
            title.textContent = folderName;

            // Create and append description paragraph
            const descriptionFile = `${folderPath}/description.txt`;
            const description = document.createElement("p");
            description.classList.add("folder-description");

            // Fetch description.txt content
            fetch(descriptionFile)
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    } else {
                        return "Ta arhiv nima opisa."; // Default description if file not found
                    }
                })
                .then(text => {
                    description.textContent = text;
                });

            // Create and append the images container (visible after loading)
            const galleryImages = document.createElement("div");
            galleryImages.classList.add("gallery-images");
            galleryImages.classList.remove("hidden"); // Remove the hidden class when images are revealed

            // Load images dynamically
            fetch(`${folderPath}/images.json`) // You can dynamically generate this JSON on the server side
                .then(response => response.json())
                .then(images => {
                    images.forEach(image => {
                        const polaroid = document.createElement("div");
                        polaroid.classList.add("polaroid");

                        const img = document.createElement("img");
                        img.src = image.path; // Assuming 'path' is a property in the JSON
                        img.alt = image.name;

                        const caption = document.createElement("div");
                        caption.classList.add("caption");
                        caption.textContent = image.name;

                        polaroid.appendChild(img);
                        polaroid.appendChild(caption);
                        galleryImages.appendChild(polaroid);
                    });
                })
                .catch(err => {
                    console.error("Error loading images: ", err);
                    const errorMessage = document.createElement("p");
                    errorMessage.textContent = "There was an issue loading images for this folder.";
                    galleryImages.appendChild(errorMessage);
                });

            // Append folder elements to the folder div
            folderDiv.appendChild(title);
            folderDiv.appendChild(description);
            folderDiv.appendChild(galleryImages);
            galleryContainer.insertBefore(folderDiv, loadMoreButton); // Insert before the load more button
        });

        // If no more folders left, hide the "Load More" button
        if (remainingFolders.length === 0) {
            loadMoreButton.style.display = "none";
        }
    });
});

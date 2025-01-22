document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('image-modal');
    const modalImage = document.querySelector('.modal-image');
    const modalCaption = document.querySelector('.modal-caption');
    const closeModal = document.querySelector('.close');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');

    let currentImageIndex = 0;
    let currentGallery = [];

    // Open Modal
    document.querySelectorAll('.gallery-images img').forEach((img, index) => {
        img.addEventListener('click', (e) => {
            const galleryId = e.target.dataset.galleryId;
            currentGallery = Array.from(
                document.querySelectorAll(`.gallery-images[data-gallery-id="${galleryId}"] img`)
            );
            currentImageIndex = currentGallery.indexOf(e.target);

            updateModal();
            modal.style.display = 'flex';
        });
    });

    // Update Modal Content
    const updateModal = () => {
        const currentImage = currentGallery[currentImageIndex];
        modalImage.src = currentImage.src;
        modalCaption.textContent = currentImage.alt;
    };

    // Close Modal
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Previous Image
    prevButton.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex - 1 + currentGallery.length) % currentGallery.length;
        updateModal();
    });

    // Next Image
    nextButton.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex + 1) % currentGallery.length;
        updateModal();
    });

    // Close modal on background click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

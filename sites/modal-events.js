// Get the modal for events
var eventModal = document.getElementById("addEventModal");
// Get the button that opens the event modal
var eventBtn = document.getElementById("openEventModalBtn");
// Get the <span> element that closes the event modal
var closeEventModal = document.getElementsByClassName("close-event")[0];

// When the user clicks the button, open the event modal
eventBtn.onclick = function() {
    eventModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeEventModal.onclick = function() {
    eventModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == eventModal) {
        eventModal.style.display = "none";
    }
}
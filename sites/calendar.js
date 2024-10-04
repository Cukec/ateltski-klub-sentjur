document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Default view is month
        editable: true, // Allow users to drag and drop events
        selectable: true, // Allow selection of multiple days
        events: [
            {
                title: 'Event 1',
                start: '2023-10-05'
            },
            {
                title: 'Event 2',
                start: '2023-10-07',
                end: '2023-10-10'
            }
        ],
        dateClick: function(info) {
            alert('Date: ' + info.dateStr);
        }
    });

    calendar.render();
});

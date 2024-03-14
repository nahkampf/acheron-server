document.addEventListener("DOMContentLoaded", function() {
    // update all times
    const timeUpdater = setInterval(updateTimes, 5000);

    function updateTimes() {
        document.querySelectorAll('.time_since_update').forEach(function(element, index) {
            var startTime = element.dataset.datetime;
            // time ago
            var timeAgo = moment(startTime).fromNow();
            element.innerHTML = timeAgo;
            if(moment(startTime).isBefore(moment().subtract(10, 'minutes'))){
                element.classList.add("warning"); 
            };
        });   
    }
    
});
$(document).ready(function () {
    var idleTime = 0;
    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });

    $(this).keypress(function (e) {
        idleTime = 0;
    });

    //Increment the idle time counter every minute.
    setInterval(function() {
        idleTime = idleTime + 1;
        if (idleTime > 14) { // 15 minutes
            toast('Your session has been expired. You are redirecting to login page...','error');
            setTimeout(function() {
                $('#logoutForm').submit();
            }, 3000);
        }
    }, 60000); // 1 minute
});
document.addEventListener('DOMContentLoaded', function () {

    var interval = null;
    var timer = 1;

    function timerValue() {
        document.getElementById("commencer").innerHTML = timer++;
    }

    document.getElementById('commencer').addEventListener('click', function () {
        clearInterval(interval);
        interval = setInterval(timerValue, 1000);
    }, false);

    document.getElementById('stop').addEventListener('click', function () {
        clearInterval(interval);
    }, false);

    document.getElementById('reset').addEventListener('click', function () {
        timer = 0;
        timerValue();
    }, false);

});
import $ from 'jquery';

function showTimeCallback(elem) {
    return () => elem.innerHTML = new Date().toLocaleTimeString('de-CH', {timeZone: 'Europe/Zurich'});
}

export default function initNow() {
    $('[data-now]').each(function () {
        const elem = this;
        setTimeout(function () {
            setInterval(showTimeCallback(elem), 1000);
            showTimeCallback(elem)();
        }, 1000 - new Date().getMilliseconds());
    });
}

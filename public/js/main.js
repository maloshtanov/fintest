var form = document.querySelector('#transfer-form');
var date = form.querySelector('input[name=date]');
var time = form.querySelector('input[name=time]');
var date_time = form.querySelector('input[name=date_time]');

form.addEventListener('submit', event => {
    var datetime = Date.parse(date.value + 'T' + time.value);

    if (Date.now() > datetime) {
        alert('Указанные дата и время уже прошли');
        event.preventDefault();
    }

    date_time.value = toGMTString(datetime);
});

function toGMTString(datetime) {
    datetime = new Date(datetime);
    var date = datetime.toDateString();
    var time = datetime.toTimeString().split(" ");

    return date + ' ' + time[0] + ' ' + time[1];
}

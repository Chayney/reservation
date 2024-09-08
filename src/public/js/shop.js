function updateDate() {
    var selectedDate = document.getElementById('date').value;
    document.getElementById('selectedDate').innerText = selectedDate;
}

function updateTime() {
    var selectedTime = document.getElementById('time').value;
    document.getElementById('selectedTime').innerText = selectedTime;
}

function updatePerson() {
    var selectedPerson = document.getElementById('person').value;
    document.getElementById('selectedPerson').innerText = selectedPerson;
}

document.addEventListener('DOMContentLoaded', function() {
    var today = new Date();
    today.setDate(today.getDate() + 1);
    var tomorrow = today.toISOString().split('T')[0];
    document.getElementById('date').setAttribute('min', tomorrow);
});
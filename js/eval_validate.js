function editEventName() {
    var eventNameElement = document.getElementById('eventName');
    var eventName = prompt("Enter new event name:", eventNameElement.innerText);

    if (eventName !== null) {
        eventNameElement.innerText = eventName;
    }
}

function editField(fieldId) {
    var fieldElement = document.getElementById(fieldId);
    var fieldValue = prompt("Enter new value:", fieldElement.innerText);

    if (fieldValue !== null) {
        fieldElement.innerText = fieldValue;
    }
}

function editQuestion(fieldId) {
    var fieldElement = document.getElementById(fieldId);
    var fieldValue = prompt("Enter new value:", fieldElement.innerText);

    if (fieldValue !== null) {
        fieldElement.innerText = fieldValue;
    }
}

// validation.js

function validateStudentNo() {
    var studentNoInput = document.getElementById("studentNo");
    var studentNoValue = studentNoInput.value;

    // Check if the student number starts with "s2020"
    if (!studentNoValue.startsWith("s20")) {
        alert("Student number must start with 's20'");
        return false; // Prevent form submission
    }

    // Check if the student number has a maximum of 11 characters
    if (studentNoValue.length > 11) {
        alert("Student number must have a maximum of 11 characters");
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}

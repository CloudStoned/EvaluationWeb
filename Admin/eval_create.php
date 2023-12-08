<?php
    require '../functions/insert_data.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Dynamic Question Form</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <center>
    <form method="post" action="../functions/eval_validate.php">

        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" required><br>

        <label for="date_created">Date Created:</label>
        <input type="date" name="date_created" required><br>

        <div id="questions-container">
            <div class="question-input">
                <label for="questions[]">Question 1:</label>
                <input type="text" name="questions[]" required style="width: 300px;" >
                <button type="button" class="remove-question">Remove</button>
            </div>
        </div>

        <button type="button" id="add-question">Add Question</button>
        <button type="button" class="remove-question clear-all-questions">Clear All</button>

        <br>
        <br>
        <input type="submit" value="Next">
        <a href="index.php" class="go-back-button">Go Back</a>

    </form>
    
    <script>
        $(document).ready(function () {
            // Add question input field
            $("#add-question").click(function () {
                var questionNumber = $(".question-input").length + 1;
                var newQuestion = '<div class="question-input">' +
                    '<label for="questions[]">Question ' + questionNumber + ':</label>' +
                    '<input type="text" name="questions[]" required style="width: 300px">' +
                    '<button type="button" class="remove-question">Remove</button>' +
                    '</div>';

                $("#questions-container").append(newQuestion);
            });

            // Remove question input field
            $("#questions-container").on("click", ".remove-question", function () {
                $(this).parent().remove();
                updateQuestionNumbers();
            });

            $(".clear-all-questions").click(function () {
                var confirmClear = confirm("Are you sure you want to clear all questions?");
                if (confirmClear) {
                    $("#questions-container").empty();
                    updateQuestionNumbers();
                }
            });            

            // Update question numbers when removing a question
            function updateQuestionNumbers() {
                $(".question-input").each(function (index) {
                    var questionNumber = index + 1;
                    $(this).find("label").text("Question " + questionNumber + ":");
                });
            }
        });
    </script>
    </center>
   

</body>
</html>

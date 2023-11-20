<?php
require 'database/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the eval_id from the form or session, wherever it is stored
    $eval_id = $_POST['eval_id'];

    // Get the current date
    $date_answered = date("Y-m-d");

    // Loop through submitted answers and insert into the answers table
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'answer_') === 0) {
            $question_id = str_replace('answer_', '', $key);
            // Assuming you trust the input; otherwise, implement proper validation/sanitization
            $answer_value = $value;

            $insert_query = "INSERT INTO answers (eval_id, question_id, answer_value, date_answered) 
                             VALUES ($eval_id, $question_id, $answer_value, '$date_answered')";

            $insert_result = mysqli_query($conn, $insert_query);

            if (!$insert_result) {
                die("Insert Error: " . mysqli_error($conn));
            }
        }
    } 

    // Redirect or display success message
    header("Location: success_page.php");
    exit();
} else {
    echo "Invalid request.";
}
?>

<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $eval_id = $_POST['eval_id'];


    $date_answered = date("Y-m-d");

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'answer_') === 0) {
            $question_id = str_replace('answer_', '', $key);

            $answer_value = $value;

            $insert_query = "INSERT INTO answers (eval_id, question_id, answer_value, date_answered) 
                             VALUES ($eval_id, $question_id, $answer_value, '$date_answered')";

            $insert_result = mysqli_query($conn, $insert_query);

            if (!$insert_result) {
                die("Insert Error: " . mysqli_error($conn));
            }
        }
    } 

    echo 'SUCCESS NAYS ONE';
} else {
    echo "Invalid request.";
}
?>

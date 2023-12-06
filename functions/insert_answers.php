<?php
require 'database.php';

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_SESSION['userDetails'])) {

        $userDetails = $_SESSION['userDetails'];
        $student_id = $userDetails['student_id']; 
    } 
    else {
        header("Location: evaluation.php");
        exit();
    }

    $eval_id = $_POST['eval_id'];

    $check_query = "SELECT * FROM answers WHERE eval_id = $eval_id AND student_id = $student_id";
    $check_result = mysqli_query($conn, $check_query);

    $date_answered = date("Y-m-d");

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'answer_') === 0) {
            $question_id = str_replace('answer_', '', $key);

            $answer_value = $value;

            $insert_query = "INSERT INTO answers (eval_id, student_id, question_id, answer_value, date_answered) 
                                VALUES ($eval_id, $student_id, $question_id, $answer_value, '$date_answered')";

            $insert_result = mysqli_query($conn, $insert_query);

            if (!$insert_result) {
                die("Insert Error: " . mysqli_error($conn));
            }
        }
    }

    echo "Answers submitted successfully.";
    echo '<a href="../Users/evaluation.php" class="go-back-button">Go Back</a>';
    
} else {
    echo "Invalid request.";
}
?>

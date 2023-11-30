<?php
require 'database.php';

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_SESSION['userDetails'])) {
        // Retrieve user details
        $userDetails = $_SESSION['userDetails'];
        $student_id = $userDetails['student_id']; 
    } 
    else {
        header("Location: evaluation.php");
        exit();
    }

    $eval_id = $_POST['eval_id'];

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
?>
    <a href="../Users/evaluation.php" class="go-back-button">Go Back</a>
<?php
} else {
    echo "Invalid request.";
}
?>

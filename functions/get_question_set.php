<?php
require 'database/database.php';


if (isset($_GET['eval_id'])) {

    $eval_id = $_GET['eval_id'];

    $question_set_sql = "SELECT question_set_id FROM evaluation WHERE eval_id = $eval_id";
    $question_set_query = mysqli_query($conn, $question_set_sql);

    if ($question_set_query) {
        $question_set = mysqli_fetch_assoc($question_set_query);
        $question_set_id = $question_set['question_set_id'];

        echo $question_set_id;

    } else {
        die("Query Error: " . mysqli_error($conn));
    }

    echo "Error: eval_id not specified.";
}
?>

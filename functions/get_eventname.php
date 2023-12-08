<?php 
require 'database.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT evaluation.eval_id, evaluation.event_id, evaluation.question_set_id, school_event.event_name, school_event.date_created
        FROM evaluation
        JOIN school_event ON evaluation.event_id = school_event.event_id";

        
$sql_query = mysqli_query($conn, $sql);


if (!$sql_query) {
    die("Query Error: " . mysqli_error($conn));
}

?>
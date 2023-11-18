<?php
require 'database/database.php';

// Check if the event_id parameter is set in the URL
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Query to get the question_set for the selected event
    $question_set_sql = "SELECT question_set_id FROM questionset WHERE event_id = $event_id";
    $question_set_query = mysqli_query($conn, $question_set_sql);

    // Check if the query was successful
    if ($question_set_query) {
        $question_set = mysqli_fetch_assoc($question_set_query);
        $question_set_id = $question_set['question_set_id'];

        // Display the question_set_id
        echo "Question Set for Event $event_id: $question_set_id";
    } else {
        die("Query Error: " . mysqli_error($conn));
    }
} else {
    // If event_id is not set in the URL, display an error or redirect as needed
    echo "Error: Event ID not specified.";
}
?>

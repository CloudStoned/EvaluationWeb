<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evaluation_admin";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$query = "SELECT DISTINCT question_id FROM answers";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}


while ($row = mysqli_fetch_assoc($result)) {
    $questionId = $row['question_id'];

    $countQuery = "SELECT answer_value, COUNT(*) AS answerCount FROM answers WHERE question_id = ? GROUP BY answer_value";
    $stmt = mysqli_prepare($conn, $countQuery);
    mysqli_stmt_bind_param($stmt, "i", $questionId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $answerValue, $answerCount);

    echo "Question ID $questionId:<br>";
    $sum = 0;
    $totalResponses = 0;

    while (mysqli_stmt_fetch($stmt)) {
        echo "Rating $answerValue:  $answerCount times.<br>";
        $sum += $answerCount;
        $totalResponses += $answerCount;
    }

    if ($totalResponses > 0) {
        $mean = (float)($sum / $totalResponses);
    } else {
        $mean = 0.00;
    }
    
    echo "Total Responses: $totalResponses<br>";
    $mean = $totalResponses > 0 ? (float)($sum / 5) : 0.00;
    echo "Mean: $mean<br>";
    


    mysqli_stmt_close($stmt);
}


mysqli_close($conn);

?>

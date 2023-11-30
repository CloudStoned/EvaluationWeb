<?php

require '../functions/database.php';

class Responses
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function CountResponsesForQuestion($questionId)
    {
        $countQuery = "SELECT COUNT(*) AS responseCount FROM answers WHERE question_id = ?";
        $stmt = mysqli_prepare($this->conn, $countQuery);
        mysqli_stmt_bind_param($stmt, "i", $questionId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $responseCount);
        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);

        return $responseCount;
    }

    public function GetResponsesForQuestion($questionId)
    {
        $query = "SELECT answer_value FROM answers WHERE question_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $questionId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $answerValue);

        $responses = [];

        while (mysqli_stmt_fetch($stmt)) {
            $responses[] = $answerValue;
        }

        mysqli_stmt_close($stmt);

        return $responses;
    }
    
    public function CountTotalResponsesForEval($eval_id)
    {
        $query = "SELECT COUNT(DISTINCT student_id) AS total_responses FROM answers WHERE eval_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $eval_id);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
    
        if (!$result) {
            die("Error: " . mysqli_error($this->conn));
        }
    
        $row = mysqli_fetch_assoc($result);
        $totalResponses = $row['total_responses'];
    
        mysqli_stmt_close($stmt);
    
        return $totalResponses;
    }

    
}
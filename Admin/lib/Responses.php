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
}
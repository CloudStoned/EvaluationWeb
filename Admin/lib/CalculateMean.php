<?php

require '../functions/database.php';

class CalculateMean
{
    private $conn;
    private $totalResponses;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function CalculateMeanForQuestion($questionId)
    {
        $countQuery = "SELECT answer_value FROM answers WHERE question_id = ?";
        $stmt = mysqli_prepare($this->conn, $countQuery);
        mysqli_stmt_bind_param($stmt, "i", $questionId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $answerValue);

        $sum = 0;
        $this->totalResponses = 0;

        while (mysqli_stmt_fetch($stmt)) {
            $sum += $answerValue;
            $this->totalResponses++;
        }

        mysqli_stmt_close($stmt);

        if ($this->totalResponses > 0) 
        {
            $mean = (float)($sum / $this->totalResponses);
        } 
        else 
        {
            $mean = 0.00;
        }

        return $mean;
    }
}

?>
<?php

require 'functions/database.php';

class CalculateMedian
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function CalculateMedianForQuestion($questionId)
    {
        $selectQuery = "SELECT answer_value FROM answers WHERE question_id = ? ORDER BY answer_value";
        $stmt = mysqli_prepare($this->conn, $selectQuery);
        mysqli_stmt_bind_param($stmt, "i", $questionId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $answerValue);

        $values = [];

        while (mysqli_stmt_fetch($stmt)) {
            $values[] = $answerValue;
        }

        mysqli_stmt_close($stmt);

        $count = count($values);

        if ($count === 0) {
            return null; 
        }

        sort($values);

        $middle = (int)($count / 2);

        if ($count % 2 === 0) {
            
            return ($values[$middle - 1] + $values[$middle]) / 2;
        } else {
            
            return $values[$middle];
        }
    }
}

?>
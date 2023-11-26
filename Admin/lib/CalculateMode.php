<?php

require '../functions/database.php';

class CalculateMode
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function CalculateModeForQuestion($questionId)
    {
        $countQuery = "SELECT answer_value, COUNT(*) AS answerCount FROM answers WHERE question_id = ? GROUP BY answer_value ORDER BY answerCount DESC LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $countQuery);
        mysqli_stmt_bind_param($stmt, "i", $questionId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $modeValue, $modeCount);

        mysqli_stmt_fetch($stmt); 

        mysqli_stmt_close($stmt);

        return $modeCount > 1 ? $modeValue : null;
    }
}

?>

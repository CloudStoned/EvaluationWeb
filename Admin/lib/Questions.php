<?php

require '../functions/database.php';

class Questions
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function GetQuestions($eval_id, $question_id)
    {
        $query = "SELECT q.question_id, q.question
        FROM questions q
        JOIN questionset qs ON q.question_set_fk = qs.question_set_id
        JOIN evaluation e ON qs.event_id = e.event_id
        WHERE e.eval_id = ? AND q.question_id = ?";
        
        $stmt = mysqli_prepare($this->conn, $query);

        if ($stmt === false) {
            die("Error in prepared statement: " . mysqli_error($this->conn));
        }

        mysqli_stmt_bind_param($stmt, "ii", $eval_id, $question_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die("Error: " . mysqli_error($this->conn));
        }

        $questions = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $questions[] = $row['question'];
        }

        mysqli_stmt_close($stmt);

        return $questions;
    }
    
    public function GetQuestionsForDropDown($eval_id)
    {
        $question_set_query = mysqli_query($this->conn, "SELECT question_id, question FROM questions WHERE question_set_fk = $eval_id");
    
        if (!$question_set_query) {
            die("Error: " . mysqli_error($this->conn));
        }
    
        return $question_set_query;
    }
    
    

}

?>

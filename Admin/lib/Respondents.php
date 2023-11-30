<?php

require '../functions/database.php';

class Respondents
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function GetRespondentsForCourses($eval_id)
    {
        $countRespondentsQuery = "SELECT s.course, COUNT(DISTINCT CASE WHEN a.eval_id = ? THEN s.student_id END) as student_count
        FROM students s JOIN answers a ON s.student_id = a.student_id GROUP BY s.course HAVING student_count > 0 ORDER BY s.course ";
        $stmt = mysqli_prepare($this->conn, $countRespondentsQuery);
        mysqli_stmt_bind_param($stmt, "i", $eval_id); 
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $course, $student_count);
        $result = [];
        while (mysqli_stmt_fetch($stmt)) {
            $result[] = ["course" => $course, "student_count" => $student_count];
        }

        mysqli_stmt_close($stmt);

        return $result;
    }

    public function GetRespondentsForQuestion($eval_id)
    {
        
    }

    
    
}
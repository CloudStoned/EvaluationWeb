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

    public function GetRatingsForEachQuestion($eval_id)
    {
        $query = "SELECT
            q.question_id,
            q.question,
            a.eval_id,
            s.course,
            COUNT(CASE WHEN a.answer_value = 1 THEN 1 END) as Rating_1,
            COUNT(CASE WHEN a.answer_value = 2 THEN 1 END) as Rating_2,
            COUNT(CASE WHEN a.answer_value = 3 THEN 1 END) as Rating_3,
            COUNT(CASE WHEN a.answer_value = 4 THEN 1 END) as Rating_4,
            COUNT(CASE WHEN a.answer_value = 5 THEN 1 END) as Rating_5

        FROM
            answers a
        JOIN
            students s ON a.student_id = s.student_id
        JOIN
            questions q ON a.question_id = q.question_id
        WHERE
            a.eval_id = ?
        GROUP BY
            q.question_id, a.eval_id, s.course
        ORDER BY
            q.question_id, s.course;
        ";
        
        $stmt = mysqli_prepare($this->conn,$query);
        mysqli_stmt_bind_param($stmt, "i", $eval_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Question ID</th>
                            <th>Question</th>
                            <th>Eval ID</th>
                            <th>Course</th>
                            <th>Rating 1</th>
                            <th>Rating 2</th>
                            <th>Rating 3</th>
                            <th>Rating 4</th>
                            <th>Rating 5</th>
                        </tr>
                    </thead>
                    <tbody>";
    
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['question_id']}</td>
                        <td>{$row['question']}</td>
                        <td>{$row['eval_id']}</td>
                        <td>{$row['course']}</td>
                        <td>{$row['Rating_1']}</td>
                        <td>{$row['Rating_2']}</td>
                        <td>{$row['Rating_3']}</td>
                        <td>{$row['Rating_4']}</td>
                        <td>{$row['Rating_5']}</td>
                    </tr>";
            }
    
            echo "</tbody></table>";
        } else {
            echo "No results found";
        }
    
        mysqli_stmt_close($stmt);
    }
    
    
    
}
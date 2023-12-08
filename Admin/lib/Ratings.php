<?php

require '../functions/database.php';

class Ratings
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function GetRatingsForEachQuestion($eval_id, $question_id)
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
                a.eval_id = ? AND q.question_id = ?
            GROUP BY
                q.question_id, a.eval_id, s.course
            ORDER BY
                s.course;
            ";
        
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $eval_id, $question_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            if ($result->num_rows > 0) {
                echo "<table border='1'>
                        <thead>
                                <th>Number</th>
                                <th>Courses</th>
                                <th>Rating 1</th>
                                <th>Rating 2</th>
                                <th>Rating 3</th>
                                <th>Rating 4</th>
                                <th>Rating 5</th>
                            </tr>
                        </thead>
                        <tbody>";

                $counter = 1;

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$counter}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['Rating_1']}</td>
                            <td>{$row['Rating_2']}</td>
                            <td>{$row['Rating_3']}</td>
                            <td>{$row['Rating_4']}</td>
                            <td>{$row['Rating_5']}</td>
                        </tr>";
                        $counter++;
                }
        
                echo "</tbody></table>";
            } else {
                echo "No results found for question {$question_id}";
            }
        
            mysqli_stmt_close($stmt);
        }
        
}

<?php
require '../functions/get_question_set.php';

if (isset($_GET['eval_id'])) {
    $eval_id = $_GET['eval_id'];

    $question_set_query = mysqli_query($conn, "SELECT * FROM questions WHERE question_set_fk = $eval_id");

    if ($question_set_query) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Evaluation Questions</title>
    <script>
        function validateForm() {
            var allRadios = document.querySelectorAll('input[type="radio"]');
            var allChecked = true;

            for (var i = 0; i < allRadios.length; i++) {
                if (!allRadios[i].checked) {
                    allChecked = false;
                    break;
                }
            }

            if (!allChecked) {
                alert('Please answer all questions before submitting.');
                return false;
            }

            return true;
        }
    </script>

</head>

<body>
    <center>
        <form method="post" action="insert_answers.php" onsubmit="return validateForm()">
            <input type="hidden" name="eval_id" value="<?= $eval_id; ?>">

            <h3>1 is the lowest, 5 is the highest</h3>

            <table>
                <thead>
                    <tr>
                        <th>Question ID</th>
                        <th>Question Text</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($question = mysqli_fetch_assoc($question_set_query)) {
                        echo '<tr>';
                        echo '<td>' . $question['question_id'] . '</td>';
                        echo '<td>' . $question['question'] . '</td>';
                        echo '<td>';

                        for ($i = 1; $i <= 5; $i++) {
                            echo '<label> 
                                    <input type="radio" name="answer_' . $question['question_id'] . '" value="' . $i . '">' . $i . 
                                '</label>';
                        }

                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <input type="submit" value="Submit Answer">
            <a href="../Users/evaluation.php" class="go-back-button">Go Back</a>
        </form>
    </center>
</body>
</html>

<?php
    } else {
        die("Query Error: " . mysqli_error($conn));
    }
} 
else {
    echo "Error: eval_id not specified.";
}
?>
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

</head>

<body>
    <center>
        <form method="post" action="insert_answers.php" onsubmit="return validateForm()">
            <input type="hidden" name="eval_id" value="<?= $eval_id; ?>">
            <table>
                <thead>
                    <tr>
                        <th>Question ID</th>
                        <th>Question Text</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($question = mysqli_fetch_assoc($question_set_query)) {
                        echo '<tr>';
                        echo '<td>' . $question['question_id'] . '</td>';
                        echo '<td>' . $question['question'] . '</td>';
                    }
                    ?>
                </tbody>
            </table>
            <a href="../Admin/eval_details.php" class="go-back-button">Go Back</a>
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

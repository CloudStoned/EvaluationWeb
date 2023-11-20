<?php
require 'functions/get_eventname.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluations</title>
</head>
<body>
    <h2>Evaluation</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Eval ID</th>
                <th>Author</th>
                <th>Event Name</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Ensure $sql_query is defined and contains the result set
            while ($results = mysqli_fetch_array($sql_query)) {
            ?>
                <tr>
                    <td><?php echo $results['eval_id'] ?></td>
                    <td><?php echo $results['author_name'] ?></td>
                    <td><?php echo $results['event_name'] ?></td>
                    <td><?php echo $results['date_created'] ?></td>
                    <td>
                        <a href="eval_questions.php?eval_id=<?php echo $results['eval_id']; ?>">Answer Evaluation</a>
                    </td>
                </tr>
            <?php
            }
            
            if (mysqli_num_rows($sql_query) === 0) {
                echo '<tr><td colspan="4">No evaluations found</td></tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>
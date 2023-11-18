<?php
    require 'functions/get_evaluation.php';
    require 'functions/get_question_set.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluations</title>
</head>
<body>
    <h2> Evaluation </h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Eval ID</th>
                <th>Event Name</th>
                <th>Date Created</th>
        </thead>

        <tbody>
            <?php while ($results = mysqli_fetch_array($sql_query)) { ?>
                <tr>
                    <td><?php echo $results['eval_id'] ?></td>
                    <td><?php echo $results['event_name'] ?></td>
                    <td><?php echo $results['date_created'] ?></td>
                    <td>
                        <a href="functions/get_question_set.php">Get Question Set</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

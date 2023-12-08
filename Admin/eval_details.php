<?php
require '../functions/get_eventname.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluations</title>
</head>
<body>
    <h2>Evaluation Details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Eval ID</th>
                <th>Event Name</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($results = mysqli_fetch_array($sql_query)) {
            ?>
                <tr>
                    <td><?php echo $results['eval_id'] ?></td>
                    <td><?php echo $results['event_name'] ?></td>
                    <td><?php echo $results['date_created'] ?></td>
                    <td>
                        <a href="eval_remove.php?eval_id=<?php echo $results['eval_id']; ?>" onclick="return confirm('Are you sure you want to remove this evaluation?')">Remove</a>
                    </td>
                    <td>
                        <a href="eval_view.php?eval_id=<?php echo $results['eval_id']; ?>">View Questions</a>
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
    <a href="index.php" class="go-back-button">Go Back</a>
</body>
</html>

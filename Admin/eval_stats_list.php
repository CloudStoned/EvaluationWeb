<?php
require '../functions/get_eventname.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Evaluations</title>
</head>
<body>
    <h2>Event Stats Report</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Event Name</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($results = mysqli_fetch_array($sql_query)) {
            ?>
                <tr>
                    <td><?php echo $results['event_name'] ?></td>
                    <td>
                        <a href="eval_stats.php?eval_id=<?php echo $results['eval_id']; ?>">View Stats</a> <!--PASS ALSO THE QUIESTIONSET ID -->
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

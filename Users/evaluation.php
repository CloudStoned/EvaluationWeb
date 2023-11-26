<?php
require '../functions/get_eventname.php';

session_start();

if(isset($_SESSION['userDetails'])) {
    $userDetails = $_SESSION['userDetails'];
} 
else {
    header("Location: index.php");
    exit();
}
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
    <p>Welcome, <?php echo $userDetails['name']; ?>!</p>
    <p>Your Student No is: <?php echo $userDetails['studentNo']; ?></p>
    
    <center>
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
                while ($results = mysqli_fetch_array($sql_query)) {
                ?>
                    <tr>
                        <td><?php echo $results['eval_id'] ?></td>
                        <td><?php echo $results['author_name'] ?></td>
                        <td><?php echo $results['event_name'] ?></td>
                        <td><?php echo $results['date_created'] ?></td>
                        <td>
                            <a href="../functions/eval_questions.php?eval_id=<?php echo $results['eval_id']; ?>">Answer Evaluation</a>
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
    </center>
</body>
</html>

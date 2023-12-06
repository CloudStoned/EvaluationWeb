<?php
require '../functions/get_eventname.php';

session_start();

if (isset($_SESSION['userDetails'])) {
    $userDetails = $_SESSION['userDetails'];
} else {
    header("Location: index.php");
    exit();
}

// Check if there is a message
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    if ($message == 'already_answered') {
        echo "You have already answered for this evaluation.";
    }
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
    <p> Course & Yr: <?php echo $userDetails['course'] ?> - <?php echo $userDetails['yearlevel'] ?>  </p>
    <p><a href="logout.php">Logout</a></p>
    
    <center>
        <h2>Evaluation</h2>
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
                            <a href="../functions/eval_questions.php?eval_id=<?php echo $results['eval_id']; ?>&student_id=<?php echo $userDetails['student_id']; ?>">Answer Evaluation</a>
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

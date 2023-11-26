<?php
require '../functions/get_eventname.php';

if(isset($_GET['eval_id'])) {
    $eval_id = $_GET['eval_id'];

    $deleteQuery = "DELETE FROM evaluation WHERE eval_id = $eval_id";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if($deleteResult) {

        echo '<script>alert("Evaluation removed successfully.");</script>';
    } else {
        // Deletion failed
        echo '<script>alert("Error removing evaluation: ' . mysqli_error($conn) . '");</script>';
    }
} else {
    // Redirect to the index page if eval_id is not set
    header("Location: index.php");
    exit();
}

header("Location: index.php");
exit();
?>

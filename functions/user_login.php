<?php
require 'user_read.php';

if(isset($_POST['login'])) {
    $studentNo = $_POST['studentNo'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE studentNo = '$studentNo' AND password = '$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();

        session_start();
        $_SESSION['userDetails'] = $userDetails;

        header("Location: ../Users/evaluation.php");
        exit(); 
    } 
    else {
        echo "Invalid credentials. Please try again.";
    }
}
?>

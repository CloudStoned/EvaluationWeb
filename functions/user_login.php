<?php
require 'user_read.php';

if(isset($_POST['login'])) {
    $studentNo = $_POST['studentNo'];
    $password = $_POST['password'];

    $queryStudent = "SELECT * FROM students WHERE studentNo = '$studentNo' AND password = '$password'";
    $queryAdmin = "SELECT * FROM admins WHERE username = '$studentNo' AND password = '$password'";
    
    $resultStudent = $conn->query($queryStudent);
    $resultAdmin = $conn->query($queryAdmin);

    if ($resultStudent && $resultStudent->num_rows > 0) {
        $userDetails = $resultStudent->fetch_assoc();

        session_start();
        $_SESSION['userDetails'] = $userDetails;

        header("Location: ../Users/evaluation.php");
        exit(); 
    } elseif ($resultAdmin && $resultAdmin->num_rows > 0) {
        // Admin login
        header("Location: ../Admin/index.php");
        exit();
    } else {
        echo "Invalid credentials. Please try again.";
    }
}
?>

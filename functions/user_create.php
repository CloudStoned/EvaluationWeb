<?php
require 'database.php';

if (isset($_POST['create'])) {
    $studentNo = $_POST['studentNo'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $password = $_POST['password'];

    $checkQuery = "SELECT * FROM users WHERE studentNo = '$studentNo'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("StudentNo already exists! Please choose a different one.")</script>';
        echo '<script>window.location.href = "../Users/create_user.php"</script>';
    } else {
        // Insert new user with specified columns
        $queryCreate = "INSERT INTO users (`studentNo`, `name`, `course`, `year`, `password`) VALUES ('$studentNo', '$name', '$course', '$year', '$password')";
        $sqlCreate = mysqli_query($conn, $queryCreate);

        if ($sqlCreate) {
            echo '<script>alert("Successfully created!")</script>';
        } else {
            echo '<script>alert("Error creating user: ' . mysqli_error($conn) . '")</script>';
        }
    }

    echo '<script>window.location.href = "../Users/index.php"</script>';
} else {
    echo '<script>window.location.href = "../Users/index.php"</script>';
}
?>
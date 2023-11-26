<?php
require 'database.php';

if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $checkQuery = "SELECT * FROM admins WHERE username = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("Username already exists! Please choose a different one.")</script>';
        echo '<script>window.location.href = "../Users/create_admin.php"</script>';
    } else {
        // Insert new admin with specified columns
        $queryCreate = "INSERT INTO admins (`username`, `password`) VALUES ('$username', '$password')";
        $sqlCreate = mysqli_query($conn, $queryCreate);

        if ($sqlCreate) {
            echo '<script>alert("Successfully created admin account!")</script>';
        } else {
            echo '<script>alert("Error creating admin account: ' . mysqli_error($conn) . '")</script>';
        }
    }

    echo '<script>window.location.href = "../Users/index.php"</script>';
} else {
    echo '<script>window.location.href = "../Users/index.php"</script>';
}
?>

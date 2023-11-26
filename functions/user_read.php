<?php
require 'database.php';


if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$queryUsers = "SELECT * FROM students";
$sqlUsers = mysqli_query($conn, $queryUsers);


if (!$sqlUsers) {
    die("Query error: " . mysqli_error($conn));
}
?>
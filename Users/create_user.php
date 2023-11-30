<?php
    require '../functions/user_read.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="../js/validation.js"></script>
    <title>Create Student Account</title>
</head>

<style>
    html, body {
        margin: 0;
        padding: 0;
    }
    .main {
        height: 10vh;

        /*Grid */
        display: grid;
        grid-template-rows: auto 1fr;
        justify-items: center;
        row-gap: 10px; /*paragraph Spacing */
    }
    .main .create-main {
        grid-row: 1/2;
        display: grid;
        grid-auto-rows: auto;
        row-gap: 5px;
    }
    .main .create-main h3{
        text-align: center;
    }

    .main .read-main{
        grid-row: 2/3;
    }
    .main .read-main tr th{
       width: 200px;
    }
    .main .read-main tr td{
        text-align: center;
    }
    .main .read-main tr td:nth-child(4){
        display: grid;
        grid-auto-flow: column;
    }
    .main .read-main tr td {
    text-align: center;
    margin: 5px 0; /* Adjust as needed */
    }

    .main .read-main tr td {
    text-align: left; /* Change text alignment to left */
    margin: 5px 0; /* Adjust as needed */
    }


</style>

<body>
<div class="main">
    <h1 class="create-main">Create Student Account</h1>
    <form class="form-horizontal" action="../functions/user_create.php" method="post" onsubmit="return validateStudentNo();">

    <div class="form-group">
        <label class="control-label col-sm-1 col-xs-1" for="studentNo">StudentNo</label>
        <div class="col-sm-11 col-xs-11">
            <input type="text" class="form-control" name="studentNo" id="studentNo" placeholder="ex: s2021****" required />
        </div>
    </div>
   
    <div class="form-group">
        <label class="control-label col-sm-1 col-xs-1" for="name">Name</label>
        <div class="col-sm-11 col-xs-11">
            <input type="text" class="form-control" name="name" id="name" placeholder="ex: Dela Cruz, Juan" required />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-1 col-xs-1" for="course">Course</label>
        <div class="col-sm-11 col-xs-11">
            <input type="text" class="form-control" name="course" id="name" placeholder="ex: BSCS" required />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-1 col-xs-1" for="year">Year</label>
        <div class="col-sm-11 col-xs-11">
            <input type="number" class="form-control" name="year" id="year" placeholder="ex: 3" required />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-1" for="password">Password</label>
        <div class="col-sm-11">
            <input type="password" class="form-control" name="password" id="password" placeholder="*****" required />
        </div>
    </div>

    <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-primary" name="create" value="CREATE" />
            </div>
            <a href="../index.html" class="go-back-button">Go Back</a>
    </div>
    </form>

</div>

</body>
</html>




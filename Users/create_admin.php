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
    <title>Create Admin Account</title>
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
        <h1>Create Admin Account</h1>
        <form class="form-horizontal" action="../functions/admin_create.php" method="post">
            <div class="form-group">
                <label class="control-label col-sm-1 col-xs-1" for="username">Username</label>
                <div class="col-sm-11 col-xs-11">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-1" for="password">Password</label>
                <div class="col-sm-11">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required />
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-primary" name="create" value="CREATE" />
                </div>
                <a href="../Users/index.php" class="go-back-button">Go Back</a>
            </div>
        </form>
    </div>
</body>
</html>




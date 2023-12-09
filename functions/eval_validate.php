<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Evaluation</title>
</head>
<body>
    <center>
        <h1> CHECK YOUR EVALUATION </h1>
        <h2>BEFORE SUBMITTING</h3>

    <?php

    require '../functions/database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
        $date_created = mysqli_real_escape_string($conn, $_POST['date_created']);
        $questions = $_POST['questions'];
    ?>
    
        <form method="post" action="../functions/insert_data.php">
            <input type="hidden" name="event_name" value="<?= htmlspecialchars($event_name) ?>">
            <input type="hidden" name="date_created" value="<?= htmlspecialchars($date_created) ?>">
            <input type="hidden" name="questions" value="<?= htmlspecialchars(serialize($questions)) ?>">
            
            <p>Event Name: <span id='eventName'><?= $event_name ?></span> <button type="button" onclick='editEventName()'>Edit</button></p>
            <p>Date Created: <span id='dateCreated'><?= $date_created ?></span> <button type="button" onclick='editField("dateCreated")'>Edit</button></p>
    
            <?php
                foreach ($questions as $index => $question) {
                    echo "<p>Question " . ($index + 1) . ": <span id='question_$index'>$question</span> <button type='button' onclick='editQuestion(\"question_$index\")'>Edit</button>";
                }
            ?>
    
            <input type="submit" value="Submit">
            <a href="../Admin/eval_create.php" class="go-back-button">Go Back</a>
        </form>
    </center>
    
    <?php
    }
    mysqli_close($conn);
    ?>
    
    <script src="../js/eval_validate.js"></script>

</body>
</html>

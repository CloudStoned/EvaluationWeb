<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Storage</title>
</head>
<body>
    <?php

    require '../functions/database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $event_name = isset($_POST['event_name']) ? mysqli_real_escape_string($conn, $_POST['event_name']) : '';
        $date_created = isset($_POST['date_created']) ? mysqli_real_escape_string($conn, $_POST['date_created']) : '';
        $questions = isset($_POST['questions']) ? unserialize($_POST['questions']) : [];

        $sql_event = "INSERT INTO school_event (event_name, date_created) VALUES (?, ?)";
        $sql_questionset = "INSERT INTO questionset (event_id) VALUES (?)";
        $sql_questions = "INSERT INTO questions (question_set_fk, question) VALUES (?, ?)";
        $sql_evaluation = "INSERT INTO evaluation (event_id, question_set_id) VALUES (?, ?)";

        $stmt_event = mysqli_prepare($conn, $sql_event);
        $stmt_questionset = mysqli_prepare($conn, $sql_questionset);
        $stmt_questions = mysqli_prepare($conn, $sql_questions);
        $stmt_evaluation = mysqli_prepare($conn, $sql_evaluation);

        if ($stmt_event && $stmt_questionset && $stmt_questions && $stmt_evaluation) {
            // Insert event
            mysqli_stmt_bind_param($stmt_event, "ss", $event_name, $date_created);

            if (mysqli_stmt_execute($stmt_event)) {
                $event_id = mysqli_insert_id($conn);

                // Insert questionset
                mysqli_stmt_bind_param($stmt_questionset, "i", $event_id);

                if (mysqli_stmt_execute($stmt_questionset)) {
                    $question_set_id = mysqli_insert_id($conn);

                    // Insert questions
                    foreach ($questions as $question) {
                        mysqli_stmt_bind_param($stmt_questions, "is", $question_set_id, $question);
                        mysqli_stmt_execute($stmt_questions);
                    }

                    echo "<h3>Data stored in the database successfully.</h3>";
                    echo nl2br("
                                \nEvent Name: $event_name
                                \nDate Created: $date_created
                                \nQuestion Set ID: $question_set_id
                                \n");

                    // Insert evaluation
                    mysqli_stmt_bind_param($stmt_evaluation, "ii", $event_id, $question_set_id);

                    if (mysqli_stmt_execute($stmt_evaluation)) {
                        $evaluation_id = mysqli_insert_id($conn);
                        echo "\nEvaluation ID: $evaluation_id";
                        ?>
                        <a href="../Admin/index.php" class="go-back-button">Go Back</a>
                    <?php
                    } else {
                        echo "Error Inserting Evaluation: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error inserting questionset: " . mysqli_error($conn);
                }
            } else {
                echo "Error inserting school_event: " . mysqli_error($conn);
            }

            // Close statements
            mysqli_stmt_close($stmt_event);
            mysqli_stmt_close($stmt_questionset);
            mysqli_stmt_close($stmt_questions);
            mysqli_stmt_close($stmt_evaluation);
        } else {
            echo "Error Preparing Statements: " . mysqli_error($conn);
        }

    }

    mysqli_close($conn);

    ?>
</body>
</html>

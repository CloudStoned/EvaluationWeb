<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evaluation_admin";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $date_created = mysqli_real_escape_string($conn, $_POST['date_created']);
    $questions = $_POST['questions'];

    $sql_author = "INSERT INTO author (author_name) VALUES (?)";
    $sql_event = "INSERT INTO school_event (event_name, date_created) VALUES (?, ?)";
    $sql_questionset = "INSERT INTO questionset (event_id) VALUES (?)";
    $sql_questions = "INSERT INTO questions (question_set_fk, question) VALUES (?,?)";
    $sql_evaluation = "INSERT INTO evaluation (author_id, event_id, question_set_id) VALUES (?, ?, ?)";

    $stmt_author = mysqli_prepare($conn, $sql_author);
    $stmt_event = mysqli_prepare($conn, $sql_event);
    $stmt_questionset = mysqli_prepare($conn, $sql_questionset);
    $stmt_questions = mysqli_prepare($conn, $sql_questions);
    $stmt_evaluation = mysqli_prepare($conn, $sql_evaluation);

    if ($stmt_author && $stmt_event && $stmt_questionset && $stmt_evaluation) 
    {
        // Insert author
        mysqli_stmt_bind_param($stmt_author, "s", $author_name);
        

        if (mysqli_stmt_execute($stmt_author)) 
        {
            // Insert school_event
            mysqli_stmt_bind_param($stmt_event, "ss", $event_name, $date_created);
            
            // After inserting into school_event, get the event_id
            if (mysqli_stmt_execute($stmt_event)) 
            {
                // Get the event_id of the inserted school_event
                $event_id = mysqli_insert_id($conn);

                // Insert questionset with the associated event_id
                mysqli_stmt_bind_param($stmt_questionset, "s", $event_id); // Use $event_id instead of $event_name

                if (mysqli_stmt_execute($stmt_questionset)) {
                    $questionSetId = mysqli_insert_id($conn);

                    foreach($questions as $question)
                    {
                        mysqli_stmt_bind_param($stmt_questions, "is", $questionSetId, $question);
                        mysqli_stmt_execute($stmt_questions);
                    }

                    echo "<h3>Data stored in the database successfully.</h3>";
                    echo nl2br("\nAuthor Name: $author_name
                                \nEvent Name: $event_name
                                \nDate Created: $date_created
                                \nQuestion Set ID: $questionSetId");
                } 

                else 
                {
                    echo "Error inserting questionset: " . mysqli_error($conn);
                }
            } 

            else 
            {
                echo "Error inserting school_event: " . mysqli_error($conn);
            }

        } 
        else 
        {
            echo "Error inserting author: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt_author);
        mysqli_stmt_close($stmt_event);
        mysqli_stmt_close($stmt_questionset);
        mysqli_stmt_close($stmt_questions);
    } 

    else 
    {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>

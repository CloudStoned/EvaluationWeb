<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Statistics</title>
    <link rel="stylesheet" href="../Admin/css/style.css">
</head>
<body>

    <?php
    require '../functions/database.php';
    require 'lib/CalculateMean.php';
    require 'lib/CalculateMode.php';
    require 'lib/CalculateMedian.php';
    require 'lib/CalculateVariance.php';
    require 'lib/Responses.php'; 
    require 'lib/CalculateStandardDev.php'; 
    require 'lib/Respondents.php';
    require 'lib/Questions.php';
    require 'lib/Ratings.php';
    
    $calculateMean = new CalculateMean($conn);
    $calculateMode = new CalculateMode($conn);
    $calculateMedian = new CalculateMedian($conn);
    $countResponses = new Responses($conn);
    $countRespondents = new Respondents($conn);
    $calculateVariance = new CalculateVariance($conn, $countResponses);
    $calculateStandardDev = new CalculateStandardDev($conn, $calculateVariance);
    $getQuestions = new Questions($conn);
    $getRatings = new Ratings($conn);
  
    if (isset($_GET['eval_id'])) 
    {
        $eval_id = $_GET['eval_id'];
        
        $query = "SELECT DISTINCT question_id FROM answers WHERE eval_id = $eval_id";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            die("Error: " . mysqli_error($conn));
        }

        $totalResponses = $countResponses->CountTotalResponsesForEval($eval_id);
        echo '<center>
            <h2> Total number of responses: ' . $totalResponses . '</h2>
        </center>';

        $respondents = $countRespondents->GetRespondentsForCourses($eval_id);
        echo '<center>
                <h2> Total Respondents per Course: </h2>';
        foreach ($respondents as $row) {
            echo '<p>' . $row["course"] . ': ' . $row["student_count"] . '</p>';
        }
        echo '</center>';


        if (isset($_GET['question_id'])) {
            $questionId = $_GET['question_id'];
        } else {
            $questionId = 1;
        }
        ?>

        <div class="dropDownList">
            <form method="post" action="">
                <label for="questionDropdown">Select Question: </label>
                <select id="questionDropdown" name="question_id" onchange="this.form.submit()">
                    <?php
                    $questionResult = $getQuestions->GetQuestionsForDropDown($eval_id);
                    while ($row = mysqli_fetch_assoc($questionResult)) {
                        $qid = $row['question_id'];
                        $questionText = $row['question'];
                        echo "<option value=\"$qid\"";
                        if ($questionId == $qid) echo " selected";
                        echo ">$questionText</option>";
                    }
                    ?>
                </select>
            </form>
        </div>
        
        <?php
            $responsesForeachQuestion = $getRatings->GetRatingsForEachQuestion($eval_id, $questionId);
            echo $responsesForeachQuestion;
        ?>
        
        <?php

        $counter = 1;

        while ($row = mysqli_fetch_assoc($result)){
            echo "<br>";
            $currentQuestionId = $row['question_id'];

            $questions = $getQuestions->GetQuestions($eval_id, $currentQuestionId);

            if (!empty($questions)) {
                echo "$counter)  Question: " . $questions[0] . "<br>";
                $mean = $calculateMean->calculateMeanForQuestion($currentQuestionId);
                echo "Mean: " . number_format($mean, 4) . "<br>";

                $mode = $calculateMode->calculateModeForQuestion($currentQuestionId);
                echo "Mode: " . ($mode !== null ? $mode : "No mode") . "<br>";

                $median = $calculateMedian->calculateMedianForQuestion($currentQuestionId);
                echo "Median: " . ($median !== null ? number_format($median, 2) : "No values") . "<br>";

                $variance = $calculateVariance->calculateVarianceForQuestion($currentQuestionId);
                echo "Variance: " . number_format($variance, 4) . "<br>";

                $standardDev = $calculateStandardDev->calculateStandardDeviationForQuestion($currentQuestionId);
                echo "Standard Deviation: " . number_format($standardDev, 4) . "<br>";

                $counter++;
            }

            else{
                echo "Error: Question Not Found. Eval ID: $eval_id, Question ID: $currentQuestionId <br>"; # PASS THE QUESTION SET ID FROM THE eval_list.php
            }
        }

        ?>
            <a href="eval_stats_list.php" class="go-back-button">Go Back</a>
        <?php
        mysqli_close($conn);
        }

        else
        {
            echo "Error: Evaluation ID not specified.";
        }
    ?>
</body>
</html>
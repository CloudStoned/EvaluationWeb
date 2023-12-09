<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Statistics</title>
    <link rel="stylesheet" href="../Admin/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    require 'lib/Conclusion.php';
    
    $calculateMean = new CalculateMean($conn);
    $calculateMode = new CalculateMode($conn);
    $calculateMedian = new CalculateMedian($conn);
    $countResponses = new Responses($conn);
    $countRespondents = new Respondents($conn);
    $calculateVariance = new CalculateVariance($conn, $countResponses);
    $calculateStandardDev = new CalculateStandardDev($conn, $calculateVariance);
    $getQuestions = new Questions($conn);
    $getRatings = new Ratings($conn);
    $getConclusion = new Conclusion($conn);
  
    if (isset($_GET['eval_id']) && isset($_GET['question_set_id'])) {
    {
        $eval_id = $_GET['eval_id'];
        $question_set_id = $_GET['question_set_id'];
        
        $query = "SELECT q.question_id, q.question
                FROM evaluation AS e
                JOIN questions AS q ON e.question_set_id = q.question_set_fk
                WHERE e.eval_id = $eval_id AND e.question_set_id = $question_set_id;
                ";

        $result = mysqli_query($conn, $query);


        if (!$result) {
            die("Error: " . mysqli_error($conn));
        }

        $totalResponses = $countResponses->CountTotalResponsesForEval($eval_id);
        echo '<center>
            <h2> Total number of responses: ' . $totalResponses . '</h2>
        </center>';

        $respondents = $countRespondents->GetRespondentsForCourses($eval_id);
        ?>

        <canvas id="responsesChart" width="800" height="200"></canvas>
        <script>
            var ctx = document.getElementById('responsesChart').getContext('2d');
            var responsesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_column($respondents, 'course')); ?>,
                    datasets: [{
                        label: 'Respondents Per Course',
                        data: <?php echo json_encode(array_column($respondents, 'student_count')); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <div class="dropDownList">
            <form method="post" action="">
                <label for="questionDropdown">Select Question: </label>
                <select id="questionDropdown" name="question_id" onchange="this.form.submit()">
                    <?php
                        $questionId = isset($_POST['question_id']) ? $_POST['question_id'] : 1;
                        $questionText = ""; 

                        $questionResult = $getQuestions->GetQuestionsForDropDown($eval_id);
                        while ($row = mysqli_fetch_assoc($questionResult)) {
                            $qid = $row['question_id'];

                            if ($questionId == $qid) {
                                $questionText = $row['question'];
                            }

                            echo "<option value=\"$qid\"";
                            if ($questionId == $qid) {
                                echo " selected";
                            }
                            
                            echo ">{$row['question']}</option>";
                        }
                    ?>
                </select>
            </form>
        </div>
 
        <?php
            echo "Selected Question Text: " . $questionText;
            $responsesForeachQuestion = $getRatings->GetRatingsForEachQuestion($eval_id, $questionId);
            echo $responsesForeachQuestion;
        ?>


        <center>
            <h1> Mean Levels </h1>
            <h2> Low Mean - mean is < median  </h2>
            <h2> Moderate Mean - mean is <= median  </h2>
            <h2> High Mean - mean is > median  </h2>

            <br>
            <h1> Variability Levels </h1>
            <h2> Low to Moderate - var is <= mean   </h2>
            <h2> High - var is > mean   </h2>
         
        </center>
        <?php
            $counter = 1;
            $sumOfMeans = 0;
            $sumOfMedians = 0;
            $sumOfVariance = 0;
            $medianValues = [];
            $modeValues = [];


            while ($row = mysqli_fetch_assoc($result)) {
                echo "<br>";
                $currentQuestionId = $row['question_id'];
                $questionText = $row['question'];

                $questions = $getQuestions->GetQuestions($eval_id, $currentQuestionId);

                if (!empty($questions)) {
                    echo "<center> $counter) Question: " . $questionText . "<br>";
                    $mean = $calculateMean->calculateMeanForQuestion($currentQuestionId);
                    $sumOfMeans += $mean;
                    echo "Mean: " . number_format($mean, 4) . " <br>";

                    $mode = $calculateMode->calculateModeForQuestion($currentQuestionId);
                    echo "Mode: " . ($mode !== null ? $mode : "No mode") . "<br>";
                    $modeValues[] = $mode;

                    $median = $calculateMedian->calculateMedianForQuestion($currentQuestionId);
                    $medianValues[] = $median;
                    $sumOfMedians += $median;
                    echo "Median: " . ($median !== null ? number_format($median, 2) : "No values") . "<br>";

                    $variance = $calculateVariance->calculateVarianceForQuestion($currentQuestionId);
                    echo "Variance: " . number_format($variance, 4) . "<br>";
                    $sumOfVariance += $variance;

                    $standardDev = $calculateStandardDev->calculateStandardDeviationForQuestion($currentQuestionId);
                    echo "Standard Deviation: " . number_format($standardDev, 4) . "<br>";

                    $meanConclusion = $getConclusion->GetMeanConclusion($sumOfMeans, $sumOfMedians);
                    $medianConclusion = $getConclusion->GetMedianConclusion($medianValues); 
                    $modeConclusion = $getConclusion->GetModeConclusion($modeValues);
                    $varianceConclusion = $getConclusion->GetVariabilityConclusion($sumOfMeans, $sumOfVariance);
                    
                    $counter++;

                } else {
                    echo "Error: Question Not Found. Eval ID: $eval_id, Question ID: $currentQuestionId <br>";
                }
            }

            echo "<h2>Conclusion:</h2> 
            Mean: $meanConclusion
            <br>
            Median: $medianConclusion
            <br>
            Mode: $modeConclusion
            <br>
            Variability: $varianceConclusion
            </center>";    
            ?>

        <center>
            <br>
            <a href="eval_stats_list.php" class="go-back-button">Go Back</a>
        </center>
        <?php
            mysqli_close($conn);
        }

    } 

    else {
        echo "Error: Evaluation ID or Question Set ID not specified.";
    }
    ?>
</body>
</html>
<?php

require 'functions/database.php';
require 'lib/CalculateMean.php';
require 'lib/CalculateMode.php';
require 'lib/CalculateMedian.php';
require 'lib/CalculateVariance.php';
require 'lib/Responses.php'; 
require 'lib/CalculateStandardDev.php'; // Include the CalculateStandardDev class

$calculateMean = new CalculateMean($conn);
$calculateMode = new CalculateMode($conn);
$calculateMedian = new CalculateMedian($conn);
$countResponses = new Responses($conn);
$calculateVariance = new CalculateVariance($conn, $countResponses);
$calculateStandardDev = new CalculateStandardDev($conn, $calculateVariance);

$query = "SELECT DISTINCT question_id FROM answers";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<br>";
    $questionId = $row['question_id'];

    echo "Question ID $questionId:<br>";

    $responseCount = $countResponses->CountResponsesForQuestion($questionId);
    echo "No. of Responses: $responseCount<br>";

    $mean = $calculateMean->calculateMeanForQuestion($questionId);
    echo "Mean: " . number_format($mean, 4) . "<br>";

    $mode = $calculateMode->calculateModeForQuestion($questionId);
    echo "Mode: " . ($mode !== null ? $mode : "No mode") . "<br>";

    $median = $calculateMedian->calculateMedianForQuestion($questionId);
    echo "Median: " . ($median !== null ? number_format($median, 2) : "No values") . "<br>";

    $variance = $calculateVariance->calculateVarianceForQuestion($questionId);
    echo "Variance: " . number_format($variance, 4) . "<br>";

    $standardDev = $calculateStandardDev->calculateStandardDeviationForQuestion($questionId);
    echo "Standard Deviation: " . number_format($standardDev, 4) . "<br>";
}

mysqli_close($conn);

?>

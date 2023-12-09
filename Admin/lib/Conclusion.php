<?php
require '../functions/database.php';

class Conclusion
{
    private $conn;
    private $calculateMean;
    private $calculateMedian;

    public function __construct($conn, CalculateMean $calculateMean, CalculateMedian $calculateMedian)
    {
        $this->conn = $conn;
        $this->calculateMean = $calculateMean;
        $this->calculateMedian = $calculateMedian;
    }

    public function GetMeanConclusion($mean, $median){
        $meanConclusion = "";
    
        switch (true) {
            case ($mean < $median):
                $meanConclusion = "It suggests that the mean in most questions has a low value.";
                break;
    
            case ($mean == $median):
                $meanConclusion = "It suggests that the mean in most questions has a moderate value.";
                break;
    
            case ($mean > $median):
                $meanConclusion = "It suggests that the mean in most questions has a high value.";
                break;
    
            default:
                break;
        }
    
        return $meanConclusion;
    }
    

    public function GetMedianConclusion($medianValues){
        $medianConclusion = "";
    
        if (count(array_unique($medianValues)) === count($medianValues)) 
        {
            $medianConclusion = "On each question, they have the same median";
        } 

        else 
        {
            $uniqueValues = array_unique($medianValues);
    
            foreach ($uniqueValues as $value) 
            {
                $count = array_count_values($medianValues)[$value];
                if ($count === 1) 
                {
                    $questionNumber = array_search($value, $medianValues) + 1;
                    $medianConclusion = "It suggests that the only question that has a different median is q$questionNumber.";
                }
            }
        }
    
        return $medianConclusion;
    }
    

}
?>

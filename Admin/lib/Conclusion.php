<?php
require '../functions/database.php';

class Conclusion
{
    private $conn;
    private $calculateMean;
    private $calculateMedian;

    public function __construct($conn, CalculateMean $calculateMean, CalculateMedian $calculateMedian){
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
    
    public function GetMedianConclusion($medianValues) {
        $medianConclusion = "";
    
        $uniqueValues = array_unique($medianValues);
    
        if (count($uniqueValues) === 1) {
            $medianConclusion = "On each question, they have the same median";
        } 

        elseif (count($uniqueValues) !== count($medianValues)) {
            $medianConclusion = "On each question, there's a different median";
        } 

        else {
            $differentMedianQuestion = 0;
    
            foreach ($uniqueValues as $value) {
                $count = array_count_values($medianValues)[$value];
    
                if ($count === 1) {
                    $differentMedianQuestion = array_search($value, $medianValues) + 1;
                    break;
                }
            }
    
            if ($differentMedianQuestion > 0) {
                $medianConclusion = "It suggests that the only question that has a different median is question no. $differentMedianQuestion.";
            }
        }
    
        return $medianConclusion;
    }
    
    public function GetModeConclusion($modeValues) {
        $modeConclusion = "";
    
        $uniqueValues = array_unique($modeValues);
        
        if (count($uniqueValues) === 1) {
            $modeConclusion = "On each question, they have the same most common responses";
        } 
        
        elseif (count($uniqueValues) !== count($modeValues)) {
            $modeConclusion = "On each question, there's a different favorable responses";
        }
    
        return $modeConclusion;
    }
    
    
    
    

}
?>

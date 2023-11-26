<?php
require 'functions/database.php';
        

class CalculateVariance extends CalculateMean
{
    private $responses;

    public function __construct($conn, Responses $responses)
    {
        parent::__construct($conn);
        $this->responses = $responses;
    }
    
    private function CalculateVariance($mean, $responseCount, $responses)
    {
        $counter = $responseCount;
        $summationOfSquared = 0;

        foreach ($responses as $value) {
            $differenceOfValue = $value - $mean;
            $differenceSquared = $differenceOfValue * $differenceOfValue;
            $summationOfSquared += $differenceSquared;
        }

        $variance = $summationOfSquared / ($counter - 1);

        return $variance;
    }

    public function CalculateVarianceForQuestion($questionId)
    {
        $mean = $this->CalculateMeanForQuestion($questionId);

        $responses = $this->responses->GetResponsesForQuestion($questionId);
        $responseCount = $this->responses->CountResponsesForQuestion($questionId);

        $variance = $this->CalculateVariance($mean, $responseCount, $responses);

        return $variance;
    }
}

?>

<?php
require '../functions/database.php';

class CalculateStandardDev
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function calculateStandardDeviationForQuestion($questionId)
    {
 
        $countResponses = new Responses($this->conn); 

        $calculateVariance = new CalculateVariance($this->conn, $countResponses);

        $variance = $calculateVariance->calculateVarianceForQuestion($questionId);

        $standardDev = sqrt($variance);

        return $standardDev;
    }
}

?>

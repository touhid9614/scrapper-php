<?php

class PerformanceAdGroup
{
    public $make, $model, $year, $impressions;
    
    public function __construct($make, $model, $year, $impressions)
    {
        $this->make         = $make;
        $this->model        = $model;
        $this->year         = $year;
        $this->impressions  = $impressions;
    }
}

?>

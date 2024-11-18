<?php
function myPrint($str){
  echo "<br>".$str."<br>";
}

function Stand_Deviation($arr,$num_of_elements,$average)
{
    // $num_of_elements = count($arr);
    $variance = 0.0;

            // calculating mean using array_sum() method
    // $average = array_sum($arr)/$num_of_elements;



    foreach($arr as $i)
    {
        // sum of squares of differences between
                    // all numbers and means.
        $variance += pow(($i - $average), 2);
    }

    return (float)sqrt($variance/$num_of_elements);
}
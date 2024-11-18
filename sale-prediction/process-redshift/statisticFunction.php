<?php

function calc_mean(array $arr, &$standard_deviation)
{
    $standard_deviation = standard_deviation($arr);

    return arithmatic_mean($arr);
}

function standard_deviation(array $arr)
{
    $arrSize 	= count($arr);
    $variance 	= 0.0;
    $average 	= arithmatic_mean($arr);

    foreach ($arr as $i)
    {
        $variance += pow(($i - $average), 2);
    }

    return (double)sqrt($variance / $arrSize);
}

function arithmatic_mean(array $arr)
{
    $arrSize = count($arr);

    if (!$arrSize)
    {
        return null;
    }

    return array_sum($arr) / $arrSize;
}
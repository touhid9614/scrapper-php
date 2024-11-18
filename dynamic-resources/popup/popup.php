<?php

function populate_popup_files($stock_type, $year, $make, $model)
{
    return [
        "$stock_type-$year-$make-$model-popup-bg.png",
        "$stock_type-$make-$model-popup-bg.png",
        "$stock_type-$year-popup-bg.png",
        "$stock_type-$make-popup-bg.png",
        "$stock_type-$model-popup-bg.png",
        "$year-$make-$model-popup-bg.png",
        "$year-$make-popup-bg.png",
        "$year-$model-popup-bg.png",
        "$make-$model-popup-bg.png",
        "$stock_type-popup-bg.png",
        "$year-popup-bg.png",
        "$make-popup-bg.png",
        "$model-popup-bg.png",
		"service-popup-bg.png",
        "popup-bg.png"
    ];
}

function check_popup_file($dir, $files, &$file = null)
{
    foreach ($files as $f)
    {
        if (file_exists($dir . $f))
        {
            $file = $f;
            return true;
        }
    }

    return false;
}

<?php

$fileContents = file_get_contents('budgetchecker_data.txt');
$decoded      = json_decode($fileContents, true);

$cam = 607045082;
$vl  = 1100;

foreach ($decoded as $key0 => $value0) {
    foreach ($value0 as $key1 => $value1) {
        if ($key1 == "campaigns") {
            foreach ($value1 as $key2 => $value2) {
                foreach ($value2 as $key3 => $value3) {
                    if ($value3 == $cam) {
                        echo $value2['daily_budget'];
                        exit;
                    }
                }
            }
        }
    }
}
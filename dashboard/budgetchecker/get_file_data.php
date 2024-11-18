<?php

//Retrieve the data from our text file.
require_once 'config.php';

$files      = glob(ADSYNCPATH . "caches/budgetchecker/*_data.txt");
$total_data = [];

foreach ($files as $file) {
    $fileContents = file_get_contents($file);
    $total_data[] = json_decode($fileContents, true);
}

echo json_encode($total_data);
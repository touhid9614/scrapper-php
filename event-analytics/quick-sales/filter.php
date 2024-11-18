<?php


$data_directory = dirname(dirname(__DIR__)) . '/adwords3/data';
if(!defined('DATA_DIR')) {
    define('DATA_DIR', $data_directory);
}

$cron_name = 'lithiahyundaireno';

$csv_dir = DATA_DIR . "/trainingdata/$cron_name";

$training_set   = "$csv_dir/training.csv";
$test_set       = "$csv_dir/test.csv";

$data = str_replace(',,', ',0,', str_replace('"', '', str_replace('""https', "\"\nhttps\"", file_get_contents($training_set))));

echo $data;
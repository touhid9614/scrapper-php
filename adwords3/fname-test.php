<?php

$fname_with_params = basename(__FILE__);

if(isset($argc) && $argc > 1) {
    for($i = 1; $i < $argc; $i++)
        $fname_with_params .= " {$argv[$i]}";
}

$grepstring = 'ps aux  | grep -v grep | grep '. escapeshellarg($fname_with_params) .' | grep -v sudo';
if (`$grepstring | wc -l` > 1)
{
    //Another innstance is already running with same parameters
    echo "Another innstance is already running with same parameters" . PHP_EOL;
    exit;
}

echo "Not already running" . PHP_EOL;

//Rest of the script here
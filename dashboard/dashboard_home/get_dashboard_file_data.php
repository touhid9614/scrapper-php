<?php

function get_summary_data($dealer_name) {
    require_once dirname(__DIR__) . '/config.php';
    $file_directory = ADSYNCPATH . 'caches/dashboard-home/';
    $fileContents = file_get_contents($file_directory . $dealer_name . '.txt');
    $decoded = json_decode($fileContents, true);
    return $decoded['summary_data'];
}

function get_monthly_data($dealer_name) {
    require_once dirname(__DIR__) . '/config.php';
       $file_directory = ADSYNCPATH . 'caches/dashboard-home/';
    $fileContents = file_get_contents($file_directory . $dealer_name . '.txt');
    $decoded = json_decode($fileContents, true);
    return $decoded['monthly_data'];
}

function get_yearly_data($dealer_name) {
    require_once dirname(__DIR__) . '/config.php';
    $file_directory = ADSYNCPATH . 'caches/dashboard-home/';
    $fileContents = file_get_contents($file_directory . $dealer_name . '.txt');
    $decoded = json_decode($fileContents, true);
    return $decoded['yearly_data'];
}

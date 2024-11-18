<?php

$date = new DateTime();
$date->sub(new DateInterval('P5M'));

$startDate = $date->format('Y-m-d');
$endDate   = date('Y-m-d');

echo $startDate . PHP_EOL;
echo $endDate . PHP_EOL;

echo "Current Date : " . $endDate . PHP_EOL;
echo "Last Sunday : " . date('Y-m-d', strtotime($endDate . 'last sunday')) . PHP_EOL;

$last_date = strtotime($endDate . 'last sunday');

$result = [];

for ($i = 0; $i < 20; $i++) {
    $end_date   = $last_date + (24 * 3600) - 1;
    $start_date = strtotime(date('Y-m-d', $end_date) . 'last monday');

    $key = date('d, M', $end_date);

    $result[$key] = [
        'start_time'    => $start_date,
        'end_time'      => $end_date,
        'engaged_users' => 0,
        'vehicle_sold'  => 0,
    ];

    echo "From " . date('d, M', $start_date) . " to " . date('d, M', $end_date) . PHP_EOL;
    $last_date = strtotime(date('Y-m-d', $start_date) . 'last sunday');
}

$year  = substr($row[0], 0, 4);
$month = substr($row[0], 4, 2);
$day   = substr($row[0], 6, 2);

$timestamp = mktime(0, 0, 0, $month, $day, $year);

echo $timestamp . ' date ' . date('Y-m-d', $timestamp) . PHP_EOL;

<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

/* SMEDIA DIRECTORY MAPPING */
$base_dir = dirname(dirname(__DIR__));
require_once $base_dir . '/vendor/autoload.php';

$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $scrapper_configs;

$CSV_DIR    = "{$adwords_dir}/client-data/";
$scan_put   = scan_dir($CSV_DIR);
$fileList   = $scan_put['files'];
$filetime   = [];
$csvDealers = [];
$groupNames = [];
$output     = [];

foreach ($scrapper_configs as $cron => $sc) {
    $entry_points = isset($sc['entry_points']) ? $sc['entry_points'] : [];
    $temp         = '';

    foreach ($entry_points as $stk_type => $url) {
        if (is_array($url)) {
            continue;
        }

        if (endsWith($url, '.csv')) {
            $temp = $url;
        }
    }

    if (!empty($temp) && isset($CronConfigs[$cron])) {
        $csvDealers[$cron] = $temp;
    }
}

$dealerSet   = array_keys($csvDealers);
$joinDealers = implode("', '", $dealerSet);
$query       = "SELECT dealership, company_name, group_name, status, websites FROM dealerships WHERE dealership IN ('$joinDealers');";
$db_connect  = new DbConnect('');
$result      = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($result)) {
    $groupNames[$row['dealership']] = [
        'company_name' => $row['company_name'],
        'group_name'   => $row['group_name'],
        'websites'     => $row['websites'],
        'status'       => $row['status'],
    ];
}

foreach ($fileList as $file) {
    if (endsiWith($file, '.csv')) {
        $filetime[fileNameChange($file)] = filemtime($file);
    }
}

foreach ($csvDealers as $cron => $csv_file_url) {
    $output[] = [
        'dealership'   => $cron,
        'company_name' => $groupNames[$cron]['company_name'],
        'group_name'   => $groupNames[$cron]['group_name'],
        'websites'     => $groupNames[$cron]['websites'],
        'status'       => $groupNames[$cron]['status'],
        'csv_url'      => $csv_file_url,
        'updated_at'   => $filetime[trim($csv_file_url)],
    ];
}

echo json_encode($output);

function fileNameChange($file)
{
    return trim(str_replace('/var/www/html/tm.smedia.ca', 'https://tm.smedia.ca', $file));
}
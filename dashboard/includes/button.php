<?php

function date_range_data()
{
    return [
        "this_month" => "This Month",
        "last_month" => "Last Month",
        "last_7"     => "Last 7 Days",
        "last_30"    => "Last 30 Days",
        "all_time"   => "All Time",
        "custom"     => "Custom",
    ];
}

function filter_input_default($type, $variable_name, $default = '')
{
    return ($val = filter_input($type, $variable_name)) ? $val : $default;
}

global $CronConfigs, $scrapper_configs;

$cron_names = get_dealership_names();
$cron_name  = filter_input_default(INPUT_GET, 'dealership', $cron_names[0]);
$date_range = filter_input_default(INPUT_GET, 'date_range', 'last_7');
$start_date = filter_input_default(INPUT_GET, 'start_date', date('Y-m-d', time() - (6 * 24 * 60 * 60)));
$end_date   = filter_input_default(INPUT_GET, 'end_date', date('Y-m-d'));

switch ($date_range) {
    case 'last_7':
        $start_date = date('Y-m-d', time() - (6 * 24 * 60 * 60));
        $end_date   = date('Y-m-d');
        break;
    case 'last_30':
        $start_date = date('Y-m-d', time() - (29 * 24 * 60 * 60));
        $end_date   = date('Y-m-d');
        break;
    case 'this_month':
        $start_date = date('Y-m-01');
        $end_date   = date('Y-m-d');
        break;
    case 'last_month':
        $start_date = date("Y-m-d", strtotime("first day of previous month"));
        $end_date   = date("Y-m-d", strtotime("last day of previous month"));
        break;
    case 'all_time':
        $start_date = '2010-01-01';
        $end_date   = date("Y-m-d");
        break;
}

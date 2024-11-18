<?php

require_once 'utils.php';
require_once 'config.php';
require_once 'tag_db_connect.php';
$_GET['customer'] = 'marshal';
require_once 'Google/Consts.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/SessionManager.php';
require_once 'Google/Analytics.php';
require_once dirname(__DIR__) . '/dashboard/config.php';
require_once dirname(__DIR__) . '/dashboard/includes/functions.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$cron_name = filter_input(INPUT_GET, 'dealership');

if (!$cron_name) {
    die();
}

$analytics = new Analytics(get_current_google_customer());

$domain = getDealerDomain($cron_name);

$profileId_key = "{$cron_name}_profileId";

$profileId = get_meta('dealer_domain', $profileId_key);

if (!$profileId) {

    $profileId = retrive_best_profileId($analytics, $domain);


    if ($profileId) {
        update_meta('dealer_domain', $profileId_key, $profileId);
    }
}

$date = new DateTime();
$date->sub(new DateInterval('P5M'));

$startDate = $date->format('Y-m-d');
$endDate = date('Y-m-d');

$metrics = array('ga:pageviews');
$dimensions = array('ga:date');
$filters = 'ga:timeOnPage>=30';


$data = get_analytics_report($analytics, $profileId, $startDate, $endDate, $metrics, $dimensions, $filters, 0);

$last_date = strtotime($endDate . 'last sunday');

$result = [];

for($i = 0; $i < 20; $i++) {
    $end_date = $last_date + (24 * 3600) - 1;
    $start_date = strtotime(date('Y-m-d', $end_date) . 'last monday');
    
    $key = date('d, M', $end_date);
    
    $result[$key] = [
        'start_time'    => $start_date,
        'end_time'      => $end_date,
        'engaged_users' => 0,
        'vehicle_sold'  => 0
    ];
    
    foreach($data->rows as $row) {
        $year   = substr($row[0], 0, 4);
        $month  = substr($row[0], 4, 2);
        $day    = substr($row[0], 6, 2);
        
        $timestamp = mktime(0, 0, 0, $month, $day, $year);
        
        if($timestamp >= $start_date && $timestamp <= $end_date) {
            $result[$key]['engaged_users'] += $row[1];
        }
    }
    
    $query = "SELECT count(stock_number) as sold_count FROM {$cron_name}_scrapped_data WHERE deleted = 1 and (updated_at between $start_date AND $end_date);";
    
    $resp = tagdb_query($query);
    
    if($resp) {
        $db_row = mysqli_fetch_assoc($resp);
        
        if($db_row) {
            $result[$key]['vehicle_sold'] = $db_row['sold_count'];
        }
        
        mysqli_free_result($resp);
    }
    
    $last_date = strtotime(date('Y-m-d', $start_date) . 'last sunday');
}

echo json_encode($result);

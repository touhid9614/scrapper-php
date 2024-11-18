<?php

require_once dirname(__DIR__) . '/dashboard/budgetchecker/config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Consts.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';
require_once dirname(__DIR__) . '/dashboard/includes/functions.php';

global $set_path, $connection;

$analytics_cache_file = ADSYNCPATH . "caches/analytics-data/analytics-zero-check.txt";
$log_file             = fopen($analytics_cache_file, "a+");

fwrite($log_file, date('Y-m-d H:i:s') . ": Analytics zero check running");
fwrite($log_file, "\n");

$today_date        = date('Y-m-d');
$beforeoneday      = date('Y-m-d', strtotime('-1 day', strtotime($today_date)));
$beforetwoday      = date('Y-m-d', strtotime('-2 day', strtotime($today_date)));
$analytics_alldata = [];

$Configs       = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];

$metrics   = array('ga: pageviews');
$analytics = new Analytics(get_current_google_customer());
$dealers   = DbConnect::get_instance()->query("SELECT dealership,company_name FROM dealerships WHERE (status='active' OR status='trial')");

while ($dealerdata = mysqli_fetch_assoc($dealers)) {
    $domain_name             = getDealerDomain($dealerdata['dealership']);
    $pageviews_before_oneday = 0;
    $pageviews_before_twoday = 0;

    $analytics_data = [
        'dealership'              => $dealerdata['dealership'],
        'domain'                  => $domain_name,
        'pageviews_before_oneday' => 0,
        'pageviews_before_twoday' => 0,
        'pageviews_diff'          => 0,
    ];

    $hostReport_beforeoneday = $analytics->GetHostReport($domain_name, $beforeoneday, $beforeoneday, $metrics);

    foreach ($hostReport_beforeoneday as $record) {
        $pageviews_before_oneday = floatval($record->rows[0][0]);
    }

    $hostReport_beforetwoday = $analytics->GetHostReport($domain_name, $beforetwoday, $beforetwoday, $metrics);

    foreach ($hostReport_beforetwoday as $record) {
        $pageviews_before_twoday = floatval($record->rows[0][0]);
    }

    // Send email those dealer which page is less than four times of previous day
    if ($pageviews_before_oneday < ($pageviews_before_twoday / 4)) {
        $analytics_data['pageviews_before_oneday'] = $pageviews_before_oneday;
        $analytics_data['pageviews_before_twoday'] = $pageviews_before_twoday;
        $analytics_alldata[]                       = $analytics_data;
    }
}

// Send email to corresponsing person from configure email
$body = '<table border="1">'
    . " <thead>"
    . "         <th>Dealership</th>"
    . "         <th>Domain</th>"
    . "         <th>Page Views (" . $beforeoneday . ")</th>"
    . "         <th>Page Views (" . $beforetwoday . ")</th>"
    . " </thead>";

for ($i = 0; $i < count($analytics_alldata); $i++) {
    $body .= "<tr>"
        . " <td>{$analytics_alldata[$i]['dealership']}</td>"
        . " <td>{$analytics_alldata[$i]['domain']}</td>"
        . " <td>{$analytics_alldata[$i]['pageviews_before_oneday']}</td>"
        . " <td>{$analytics_alldata[$i]['pageviews_before_twoday']}</td>"
        . "</tr>";
}

$body .= "</table>";

$data_query = DBConnect::get_instance()->query("SELECT name, value FROM configure_alert WHERE name='zero_analytics_email'");

if (mysqli_num_rows($data_query)) {
    $zero_analytics_email = mysqli_fetch_assoc($data_query)['value'];
    $tos                  = explode(',', $zero_analytics_email);
} else {
    $tos = ['tanvir@smedia.ca'];
}

SendEmail($tos, 'reports@smedia.ca', 'Analytics Zero Reporting', $body);
fwrite($log_file, date('Y-m-d H:i:s') . ": Email sent to " . implode(',', $tos));
fwrite($log_file, "\n");
fclose($log_file);
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

$analytics_cache_file = ADSYNCPATH . "caches/analytics-data/analytics-double-check.txt";
$log_file             = fopen($analytics_cache_file, "a+");

fwrite($log_file, date('Y-m-d H:i:s') . ": Analytics double check running");
fwrite($log_file, "\n");

$today_date        = date('Y-m-d');
$beforeoneday      = date('Y-m-d', strtotime('-1 day', strtotime($today_date)));
$beforetwoday      = date('Y-m-d', strtotime('-2 day', strtotime($today_date)));
$analytics_alldata = [];

$Configs       = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];

$metrics   = array('ga: bounceRate');
$analytics = new Analytics(get_current_google_customer());
$dealers   = DbConnect::get_instance()->query("SELECT dealership, company_name FROM dealerships WHERE status IN ('active', 'trial');");

while ($dealerdata = mysqli_fetch_assoc($dealers)) {
    $domain_name              = getDealerDomain($dealerdata['dealership']);
    $bouncerate_before_oneday = 0;
    $bouncerate_before_twoday = 0;

    $analytics_data = [
        'dealership'               => $dealerdata['dealership'],
        'domain'                   => $domain_name,
        'bouncerate_before_oneday' => 0,
        'bouncerate_before_twoday' => 0,
        'bouncerate_diff'          => 0,
    ];

    $hostReport_beforeoneday = $analytics->GetHostReport($domain_name, $beforeoneday, $beforeoneday, $metrics);

    foreach ($hostReport_beforeoneday as $record) {
        $bouncerate_before_oneday = floatval($record->rows[0][0]);
    }

    $hostReport_beforetwoday = $analytics->GetHostReport($domain_name, $beforetwoday, $beforetwoday, $metrics);

    foreach ($hostReport_beforetwoday as $record) {
        $bouncerate_before_twoday = floatval($record->rows[0][0]);
    }

    $bouncerate_diff                            = $bouncerate_before_oneday - $bouncerate_before_twoday;
    $analytics_data['bouncerate_before_oneday'] = $bouncerate_before_oneday;
    $analytics_data['bouncerate_before_twoday'] = $bouncerate_before_twoday;
    $analytics_data['bouncerate_diff']          = $bouncerate_diff;
    $analytics_alldata[]                        = $analytics_data;
}

// file_put_contents($analytics_cache_file, json_encode($analytics_alldata, JSON_PRETTY_PRINT));

// Send email to corresponsing person from configure email

$body = '<table border="1">'
    . " <thead>"
    . "         <th>Dealership</th>"
    . "         <th>Domain</th>"
    . "         <th>Bounce Rate(" . $beforetwoday . ")</th>"
    . "         <th>Bounce Rate(" . $beforeoneday . ")</th>"
    . "         <th>Bounce Rate Difference</th>"
    . " </thead>";

for ($i = 0; $i < count($analytics_alldata); $i++) {
    if (abs($analytics_alldata[$i]['bouncerate_diff']) > ($analytics_alldata[$i]['bouncerate_before_twoday'] / 2)) {
        $body .= "<tr>"
            . " <td>{$analytics_alldata[$i]['dealership']}</td>"
            . " <td>{$analytics_alldata[$i]['domain']}</td>"
            . " <td>{$analytics_alldata[$i]['bouncerate_before_oneday']}</td>"
            . " <td>{$analytics_alldata[$i]['bouncerate_before_twoday']}</td>"
            . " <td>{$analytics_alldata[$i]['bouncerate_diff']}</td>"
            . "</tr>";
    }
}

$body .= "</table>";

$data_query = DBConnect::get_instance()->query("SELECT name, value FROM configure_alert WHERE name='double_analytics_email'");

if (mysqli_num_rows($data_query)) {
    $double_analytics_email = mysqli_fetch_assoc($data_query)['value'];
    $tos                    = explode(',', $double_analytics_email);
} else {
    $tos = ['tanvir@smedia.ca'];
}

SendEmail($tos, 'reports@smedia.ca', 'Analytics Double Reporting', $body);
fwrite($log_file, date('Y-m-d H:i:s') . ": Email sent to " . implode(',', $tos));
fwrite($log_file, "\n");
fclose($log_file);
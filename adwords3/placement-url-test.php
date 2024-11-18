<?php

$minTimeOnPage = 60;
$maxBounceRate = 65;

$_GET['customer'] = "marshal";

require_once 'config.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/Types.php';
require_once 'Google/Util.php';
require_once 'Google/Consts.php';
require_once 'Google/Adwords.php';
require_once 'Google/Analytics.php';
require_once 'Google/SessionManager.php';
require_once 'cron_misc.php';
require_once 'db_connect.php';
require_once 'AdSyncer.php';
require_once 'scrapper.php';
require_once 'utils.php';
require_once 'carlist-loader.php';

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
$market_buyers, $SWFConfigs, $connection, $proxy_list, $carlist, $advanced_carlist,
$BannerConfigs, $number_of_retries;

//set it to run for no timeout
slecho("Trying to set timeout to no limit");
set_time_limit(0);
slecho("Maximum execution time: " . ini_get('max_execution_time'));

$dealers          = [];
$common_exclusion = [];

$analytics   = new Analytics(get_current_google_customer());
$filters     = "ga:timeOnPage<$minTimeOnPage,ga:bounceRate>$maxBounceRate";
$cron_name   = 'kingstondodge'; //'inlandautoinlandautocentre';
$cron_config = $CronConfigs[$cron_name];
$db_connect  = new DbConnect($cron_name);
$domain      = getDealerDomain($cron_name);

if (!$domain) {
    slecho("Domain for $cron_name could not be resolved");
    die();
}

slecho("Dealer Domain Name: $domain");

if (!isset($cron_config['customer_id'])) {
    die("CustomerId is not present for dealership $cron_name");
}

$service = new AdwordsService(
    Consts::ServiceNamespace,
    $CurrentConfig,
    $developer_token,
    $cron_config['customer_id']
);

$car = array(
    'year'  => '2014',
    'make'  => 'RAM',
    'model' => '1500',
);

$adGroupId = '31538419859';
$res       = reformat_placement('http://cars.axlegeeks.com/l/5220/2014-Ram-1500-Crew-Cab');

echo '<pre>';
print_r($res);
echo '</pre>';

$db_connect->close_connection();

<?php

require_once('config.php');
require_once('Google/TokenHelper.php');
require_once('Google/Types.php');
require_once('Google/Util.php');
require_once('Google/Consts.php');
require_once('Google/Adwords.php');
require_once('Google/Analytics.php');
require_once('Google/SessionManager.php');
require_once('cron_misc.php');
require_once('db_connect.php');
require_once('AdSyncer.php');
require_once('scrapper.php');
require_once('utils.php');
require_once('carlist-loader.php');

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
   $market_buyers, $SWFConfigs, $connection, $proxy_list, $carlist, $advanced_carlist,
   $BannerConfigs, $number_of_retries;

$cron_name      = 'barbermotors';
$cron_config    = isset($CronConfigs[$cron_name])?$CronConfigs[$cron_name]:null;

$service = new AdwordsService(Consts::ServiceNamespace, $CurrentConfig, $developer_token, $cron_config['customer_id']);

$resport = $service->GetAdGroupPerformance();

echo "<pre>";
print_r($resport);
echo "</pre>";
<?php

ini_set('display_errors', 1);
ini_set("log_errors", 1);
error_reporting(E_ALL);

require_once('config.php');
echo "Config.php loaded\n<br/>";
require_once('utils.php');
echo "utils.php loaded\n<br/>";
require_once('Google/TokenHelper.php');
echo "Google/TokenHelper.php loaded\n<br/>";
require_once('Google/Types.php');
echo "Google/Types.php loaded\n<br/>";
require_once('Google/Util.php');
echo "Google/Util.php loaded\n<br/>";
require_once('Google/Adwords.php');
echo "Google/Adwords.php loaded\n<br/>";
require_once('Google/Consts.php');
echo "Google/Consts.php loaded\n<br/>";
require_once('Google/SessionManager.php');
echo "Google/SessionManager.php loaded\n<br/>";
require_once('cron_misc.php');
echo "cron_misc.php loaded\n<br/>";
//require_once('db_connect.php');
require_once('AdSyncer.php');
echo "AdSyncer.php loaded\n<br/>";
require_once('scrapper.php');
echo "scrapper.php loaded\n<br/>";
require_once('carlist-loader.php');
echo "carlist-loader.php loaded\n<br/>";

global $CronConfigs, $CurrentConfig, $developer_token, $custom_dealerships;

$cron_name = filter_input(INPUT_GET, 'dealership')? filter_input(INPUT_GET, 'dealership') : 'inlandautoinlandautocentre';

$cron_config = isset($CronConfigs[$cron_name])?$CronConfigs[$cron_name] : false;

if($cron_config)
{
    $service = new AdwordsService(
        Consts::ServiceNamespace,
        $CurrentConfig,
        $developer_token,
        $cron_config['customer_id']
    );
    
    $campaign_name = "{$cron_name}_new_search";
    
    $entities = $service->GetCampaign($campaign_name);

    $search = false;
    $display = true;

    if (endsWith($key, "_search")) {
        $search = true;
        $display = false;
    }

    if(endsWith($key, "_color"))
    {
        $search = true;
        $display = false;
    }

    if (!$entities || count($entities) == 0) {
        if (!$budgetId) {
            $budgetAmount = isset($cron_config['budget'])? $cron_config['budget'] : 2.0;
            $budgetName = $cron_name . ' #' . time();
            echo("Info: Creating budget with budget name " . $budgetName . "\n");
            $budgetId = $service->CreateBudget($budgetName, $budgetAmount);
            if ($budgetId) {
                echo("Info: New budgetId is " . $budgetId . "\n");
            }
        }

        if (!$budgetId) {
            echo('ERROR: Unable to create budget for campaign ' . $campaign_name . "\n");
        }

        echo("Info: Creating new campaign with campaign name " . $campaign_name . "\n");

        $cid = $service->CreateCampaign($campaign_name, $budgetId, $search, $display);
        
    } else {
        $cid = $entities[0]->id;
    }
    
    echo "Campaign $campaign_name id is :$cid\n";
    MonitorAccountCost($service, $cron_name, $cron_config);
}

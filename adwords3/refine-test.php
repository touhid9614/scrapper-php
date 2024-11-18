<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

require_once('config.php');
//require_once('Google/TokenHelper.php');
require_once('Google/Types.php');
require_once('Google/Util.php');
require_once('Google/Adwords.php');
require_once('Google/Consts.php');
//require_once('Google/SessionManager.php');
require_once('cron_misc.php');
require_once('db_connect.php');
require_once('AdSyncer.php');
require_once('scrapper.php');
require_once('utils.php');
//require_once('carlist-loader.php');

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
   $market_buyers, $SWFConfigs, $connection, $proxy_list, $carlist, $advanced_carlist,
   $BannerConfigs, $number_of_retries;

//loadCarList();
//loadAdvancedCarList();

define('debug', true);

$car_data = array(
    'title' => '2017 Hyundai Elantra - $107.50 B/W',
    'year' => '2017',
    'make' => 'Hyundai',
    'model' => 'Elantra',
    'trim' => '\x2D\x20\x24107.50\x20B\x2FW',
    'price' => '$16,500.00',
    'kilometres' => '21,010 km',
    'stock_number' => '18103R',
    'engine' => '2.0L 147HP 4 Cylinder Engine',
    'body_style' => 'Sedan',
    'transmission' => 'Automatic',
    'exterior_color' => 'Blue',
    'stock_type' => 'used',
);

//RefineCarData($car_data, $carlist, $advanced_carlist);
//object_dump($car_data);

$template = '[year] [make] [model] [price] In stock now! Click to view estimated payments and discounts!';

echo processTextTemplate($template, $car_data, true);

function object_dump($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}
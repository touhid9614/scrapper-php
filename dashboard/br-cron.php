<?php

define('noprint', true);

require_once 'config.php';
require_once ADSYNCPATH . 'config.php';
require_once ABSPATH    . 'includes/functions.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once 'includes/search-inventory.php';
require_once 'includes/bounce-rate.php';

global $connection;

header('Content-Type: application/json');

$Configs = LoadConfig($set_path);

$CurrentConfig = $Configs->AccessTokens['marshal'];

$mutex = Mutex::create();

$result = get_avg_bounce_rate($connection, $mutex, true);

Mutex::destroy($mutex);
mysql_close($connection);

echo json_encode($result);
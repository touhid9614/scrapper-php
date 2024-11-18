<?php

define('noprint', true);

require_once 'config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Consts.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';
require_once '../includes/functions.php';
require_once '../includes/ajax_inc.php';
require_once ABSPATH . '/budgetchecker/includes/ajax_inc.php';
require_once 'budgetchecker_update.php';
header('Content-Type: application/json');

global $set_path, $connection;

$result        = array();
$action        = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : null;
$cron_name     = isset($_REQUEST['dealership']) ? trim($_REQUEST['dealership']) : null;
$Configs       = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];
$mutex         = Mutex::create();

switch ($action) {
    case 'get-dealers':
        $result = get_dealerships();
        break;
    case 'eval-dealer':
        $result = eval_dealership($CurrentConfig, $cron_name, $mutex);
        break;
    case 'update-budget':
        update_cache();
        $result = update_budget($CurrentConfig, $cron_name);
        break;
    case 'monthly-dealer':
        $result = monthly_dealership($CurrentConfig, $cron_name, $mutex);
        break;
    default:
        $result['error'] = array(
            'code'    => 400,
            'message' => 'Bad request: Missing required parameters',
        );
        break;
}

Mutex::destroy($mutex);
mysqli_close($connection);
echo json_encode($result);

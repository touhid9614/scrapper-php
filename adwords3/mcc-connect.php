<?php

function slecho($data)
{
    echo $data . "\n";
}

require_once 'adwords3/config.php';
require_once 'adwords3/db_connect.php';

global $CronConfigs, $connection;

header('Content-Type: application/json');

$action = isset($_GET['act']) ? trim($_GET['act']) : null;
$result = [];

switch ($action) {
    case "get-customers":
        foreach ($CronConfigs as $cron_name => $cron_config) {
            if (!isset($CronConfigs[$cron_name]['customer_id'])) {
                continue;
            }

            $result[$cron_config['customer_id']] = isset($cron_config['on15']) ? $cron_config['on15'] == true : false;
        }
        break;
    case "update-customer":
        {
            $cid = isset($_GET['cid']) ? $_GET['cid'] : null;

            if ($cid) {
                $yc  = isset($_GET['yc']) ? $_GET['yc'] : 0.0;
                $ycl = isset($_GET['ycl']) ? $_GET['ycl'] : 0;
                $yim = isset($_GET['yim']) ? $_GET['yim'] : 0;
                $tc  = isset($_GET['tc']) ? $_GET['tc'] : 0.0;
                $tcl = isset($_GET['tcl']) ? $_GET['tcl'] : 0;
                $tim = isset($_GET['tim']) ? $_GET['tim'] : 0;

                $db_connect = new DbConnect('murraywin');

                $today     = time();
                $yesterday = $today - (24 * 60 * 60);

                $db_connect->store_account_state($cid, $yesterday, $yc, $ycl, $yim);
                $db_connect->store_account_state($cid, $today, $tc, $tcl, $tim);
            }
        }
        break;
    default:
        $result = array('error' => 'Action not defined');
        break;
}

$db_connect->close_connection();

die(json_encode($result));

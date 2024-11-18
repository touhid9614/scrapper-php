<?php

require_once dirname(__DIR__) . '/dashboard/config.php';
require_once ADSYNCPATH . 'db-config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

$db_connect = new DbConnect();

$inactive_dealers = $db_connect->get_all_dealers("`status` = 'inactive' OR `status` = 'failed-trial'");

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

foreach ($inactive_dealers as $cron_name => $dealership) {
    $config_path = get_config_path($cron_name);

    if ($config_path) {
        slecho("Disabling {$cron_name} on Config {$config_path}.");
        exec("mv $config_path $config_path.cancelled");
    }
}

function get_config_path($cron_name)
{
    $configs_dir = ADSYNCPATH . 'config/';
    $resp        = exec('grep -nr \'"' . $cron_name . '"*\' ' . $configs_dir . " | awk '{print $1}'");

    if ($resp) {
        $spltd = explode(':', $resp);
        if (count($spltd) > 1 && endsWith($spltd[0], ".php")) {
            return $spltd[0];
        }
    }
    return null;
}
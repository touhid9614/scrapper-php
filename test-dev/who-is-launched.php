<?php

require_once 'config.php';
require_once 'db_connect.php';

global $CronConfigs;

$db_connect = new DbConnect('');

foreach ($CronConfigs as $cron_name => $cron_config) {
    $query  = $db_connect->query("SELECT form_live FROM dealerships WHERE dealership = '$cron_name'");
    $result = mysqli_fetch_assoc($query);

    if ($result['form_live'] == '1') {
        echo $cron_name . '<br>';
    }
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

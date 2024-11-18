<?php

function slecho($data)
{
    echo $data . '<br/>';
}

require_once 'config.php';
require_once 'db_connect.php';

global $connection, $CronConfigs;

foreach ($CronConfigs as $cron_name => $cron_config) {
    $db_connect = new DbConnect($cron_name);

    $table_name = $cron_name . '_autotrader_ads';

    $query = "DROP TABLE IF EXISTS`$table_name`;";

    if ($db_connect->query($query)) {
        echo "Info: Database for dealership $cron_name as been updated<br/>";
    } else {
        echo "Error: Unale to update Database for dealership $cron_name<br/>";
    }
}

$db_connect->close_connection(DbConnect::CLOSE_WRITE_CONNECTION);

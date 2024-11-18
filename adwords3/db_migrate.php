<?php

require_once 'config.php';
require_once 'db-config.php';
require_once 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query            = "SHOW tables WHERE Tables_in_" . $db_config_read['db_name'] . " LIKE '%_scrapped_data';";
$query_template_1 = "ALTER TABLE `%s` ADD COLUMN `vehicle_id` VARCHAR(255) NOT NULL DEFAULT '' AFTER `vin`;";

$result = mysqli_query(DbConnect::get_connection_read(), $query);
$tables = [];

if (!$result) {
    die(mysqli_error(DbConnect::get_connection_read()));
}

while ($row = mysqli_fetch_array($result)) {
    $tables[] = $row["Tables_in_" . $db_config_read['db_name']];
}

foreach ($tables as $table_name) {
    $query1     = sprintf($query_template_1, $table_name, $table_name);
    $res1       = mysqli_query(DbConnect::get_connection_read(), $query1);

    if (!$res1) {
        echo "An error occured while updating {$table_name}.<br>";
    } else {
        echo "{$table_name} updated.<br>";
    }
}
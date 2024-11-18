<?php

require_once 'config.php';
require_once 'db-config.php';
require_once 'db_connect.php';
require_once 'utils.php';

global $scrapper_configs;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query            = "SHOW tables WHERE Tables_in_" . $db_config_read['db_name'] . " LIKE '%_cartrack_data';";
$query_template_1 = "SELECT svin, previous_url, current_url FROM `%s`;";

$result = mysqli_query(DbConnect::get_connection_read(), $query);
$tables = [];

if (!$result) {
    die(mysqli_error(DbConnect::get_connection_read()));
}

while ($row = mysqli_fetch_array($result)) {
    $tables[] = $row["Tables_in_" . $db_config_read['db_name']];
}

$db_connect = new DbConnect('');

foreach ($tables as $table_name) {
    $query1 = sprintf($query_template_1, $table_name, $table_name);
    $res1   = mysqli_query(DbConnect::get_connection_read(), $query1);

    $cron_name       = str_replace('_cartrack_data', '', $table_name);
    $scrapper        = $scrapper_configs[$cron_name];
    $required_params = isset($scrapper['required_params']) ? $scrapper['required_params'] : [];

    while ($row = mysqli_fetch_assoc($res1)) {
        $old_svin = $row['svin'];
        $new_svin = url_to_svin($row['previous_url'], $required_params);
        $cur_svin = url_to_svin($row['current_url'], $required_params);
        $query    = "UPDATE $table_name SET svin = '$new_svin', current_svin = '$cur_svin' WHERE svin = '$old_svin';";
        $db_connect->query($query);
    }

    echo "$table_name is updated.<br>";
}

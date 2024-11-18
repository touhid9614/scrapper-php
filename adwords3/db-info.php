<?php

require_once 'config.php';
require_once 'db-config.php';
require_once 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query            = "SHOW tables WHERE Tables_in_" . $db_config_read['db_name'] . " LIKE '%_scrapped_data';";
$query_template_1 = "SELECT COUNT(svin) AS no_feed_count FROM `%s` WHERE no_feed = true;";

$result = mysqli_query(DbConnect::get_connection_read(), $query);
$tables = [];

if (!$result) {
    die(mysqli_error(DbConnect::get_connection_read()));
}

while ($row = mysqli_fetch_array($result)) {
    $tables[] = $row["Tables_in_" . $db_config_read['db_name']];
}

$no_feed_out = [];

foreach ($tables as $table_name) {
    $query1     = sprintf($query_template_1, $table_name, $table_name);
    $res1       = mysqli_query(DbConnect::get_connection_read(), $query1);

    if ($res1) {
		$no_feed_fetch = mysqli_fetch_assoc($res1);
		$no_feed_count = $no_feed_fetch['no_feed_count'];

		if ($no_feed_count) {
	    	$no_feed_out[$table_name] = $no_feed_count;
	    }
	} else {
		$no_feed_out[$table_name] = "N/A";
	}
}

print_r($no_feed_out);
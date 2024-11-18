<?php

require_once 'config.php';
require_once 'db-config.php';
require_once 'db_connect.php';
require_once 'utils.php';

global $scrapper_configs;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query  = "SHOW tables WHERE Tables_in_" . $db_config_read['db_name'] . " LIKE '%_scrapped_data';";
$query_template_1 = "SELECT stock_number, url FROM `%s` WHERE (svin IS NULL OR svin = '');";
$query_template_2 = "SELECT * FROM `%s` GROUP BY svin HAVING COUNT(svin) > 1;";

$result = mysqli_query(DbConnect::get_connection_read(), $query);
$tables = [];

if (!$result) {
	die(mysqli_error(DbConnect::get_connection_read()));
}

while ($row = mysqli_fetch_array($result)) {
	$tables[] = $row['Tables_in_' . $db_config_read['db_name']];
}

echo '<pre>';

foreach ($tables as $table_name) {
	if ($table_name == "hondapowersportsparts_scrapped_data") {
		continue;
	}

	$query1 = sprintf($query_template_1, $table_name, $table_name);
	$res1   = mysqli_query(DbConnect::get_connection_read(), $query1);

	if ($res1) {
		while ($data = mysqli_fetch_array($res1)) {
			$cron_name = str_replace('_scrapped_data', '', $table_name);
			$scrapper = $scrapper_configs[$cron_name];
			$required = [];

			if (isset($scrapper['required_params'])) {
				$required = $scrapper['required_params'];
			}

			$data_url = $data['url'];
			$svin = url_to_svin($data_url, $required);
			echo "svin -> $svin\n";
			$query2 = "UPDATE $table_name SET svin = '$svin' WHERE url = \"" . $data_url . "\"";
			echo $query2 . '<br>';
			$res2 = mysqli_query(DbConnect::get_connection_write(), $query2);

			if (!$res2) {
				echo "An error occured updating svin for $table_name for $data_url. error: ";
			}

			echo "\n";
		}
	} else {
		echo "$table_name is updated already";
		echo "\n";
	}
}

echo '</pre>';

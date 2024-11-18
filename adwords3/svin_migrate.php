<?php

require_once 'config.php';
require_once 'db-config.php';
require_once 'db_connect.php';
require_once 'utils.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

global $scrapper_configs;


$query  = "SHOW TABLES WHERE Tables_in_" . $db_config_read['db_name'] . " LIKE '%_scrapped_data';";
$query_template_0 = "SELECT stock_number, url FROM `%s` WHERE (svin IS NULL OR svin = '');";
$query_template_1 = "ALTER TABLE `%s` CHANGE COLUMN `svin` `svin` VARCHAR(255) NOT NULL DEFAULT '' FIRST, ADD PRIMARY KEY (`svin`);";
$query_template_2 = "ALTER TABLE `%s` DROP PRIMARY KEY;";
$query_template_3 = "SELECT * FROM `%s` GROUP BY svin HAVING COUNT(*) > 1;";
$query_template_4 = "DELETE FROM `%s` WHERE svin IN  (SELECT svin FROM (SELECT * FROM `%s`) AS X GROUP BY svin HAVING COUNT(*) > 1);";
$query5 = "SELECT tab.table_name
FROM information_schema.tables AS tab
LEFT JOIN information_schema.table_constraints AS tco
    ON tab.table_schema = tco.table_schema
	AND tab.table_name = tco.table_name
	AND tco.constraint_type = 'PRIMARY KEY'
WHERE tco.constraint_type IS NULL
	AND tab.table_schema NOT IN ('mysql', 'information_schema', 'performance_schema', 'sys')
	AND tab.table_type = 'BASE TABLE'
	AND tab.table_schema = 'spidri_ads'
	AND tab.table_name LIKE '%_scrapped_data%'
ORDER BY tab.table_schema,
    tab.table_name;";

$result = mysqli_query(DbConnect::get_connection_read(), $query5);
$tables = [];

if (!$result)
{
    die(mysqli_error(DbConnect::get_connection_read()));
}

while ($row = mysqli_fetch_array($result))
{
    $tables[] = $row['table_name'];
}

natcasesort($tables);

echo '<pre>';

foreach ($tables as $table_name)
{
	if ($table_name == "hondapowersportsparts_scrapped_data")
    {
        continue;
    }

    echo $table_name . '<br>';

    $query0 = sprintf($query_template_0, $table_name, $table_name);
	$query1 = sprintf($query_template_1, $table_name, $table_name);
    $query2 = sprintf($query_template_2, $table_name, $table_name);
    $query3 = sprintf($query_template_3, $table_name, $table_name);
    $query4 = sprintf($query_template_4, $table_name, $table_name);

    $res2 = mysqli_query(DbConnect::get_connection_write(), $query2);

	if (!$res2)
    {
        echo "An error occured updating svin for $table_name. <br>";
    }
    else
    {
        echo "$table_name updated, primary key dropped.<br>";
    }

    $res0   = mysqli_query(DbConnect::get_connection_read(), $query0);

    if ($res0)
    {
    	while ($data = mysqli_fetch_array($res0))
    	{
    		$cron_name = str_replace('_scrapped_data', '', $table_name);
            $scrapper = $scrapper_configs[$cron_name];
            $required = [];

            if (isset($scrapper['required_params']))
            {
                $required = $scrapper['required_params'];
            }

            $data_url = $data['url'];
            $svin = url_to_svin($data_url, $required);
            echo "svin -> $svin\n";

            $query5 = "UPDATE $table_name SET svin = '$svin' WHERE url = \"" . $data_url . "\"";
            $res5 = mysqli_query(DbConnect::get_connection_write(), $query5);

            if (!$res5)
            {
                echo "An error occured updating svin for $table_name for $data_url. <br>";
            }
    	}
    }
    else
    {
        echo "$table_name is updated already. <br>";
    }

    $res4 = mysqli_query(DbConnect::get_connection_write(), $query4);

    if (!$res4)
    {
    	echo "Complex query failed for $table_name .<br>";
    }

    $res1 = mysqli_query(DbConnect::get_connection_write(), $query1);

    if (!$res1)
    {
    	echo "Primary key SVIN couldn't be added for $table_name .<br>";
    }
}

echo "All Complete!";

echo '</pre>';
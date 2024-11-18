<?php

require_once 'config.php';
require_once 'db_connect.php';
require_once 'utils.php';

global $connection;

$result_dir = __DIR__ . '/data/export';

if (!file_exists($result_dir)) {
    if (!mkdir($result_dir, 0777, true)) {
        die('can not create result directory');
    }
}

function write_result_to_csv($data, $result_file)
{
    array_walk($data, function (&$value, $index) {
        if (stripos($value, ',') !== false) {
            $value = "\"$value\"";
        }
    });
    file_put_contents($result_file, implode(",", $data) . "\n", FILE_APPEND);
}

$query            = "SHOW tables WHERE Tables_in_spidri_ads_db LIKE '%_scrapped_data';";
$query_template_1 = "SELECT count(*) as count from `%s` where 1";
$query_template_2 = "SELECT stock_number, vin, stock_type, title, year, make, model, trim, price, body_style, engine, transmission, exterior_color, interior_color, kilometres, all_images, url, certified, deleted FROM `%s` where 1;";

$result = mysqli_query($connection, $query);
$tables = [];

while ($row = mysqli_fetch_array($result)) {
    $tables[] = $row['Tables_in_spidri_ads_db'];
}

echo '<pre>';
foreach ($tables as $table_name) {
    $query1 = sprintf($query_template_1, $table_name, $table_name);
    $query2 = sprintf($query_template_2, $table_name, $table_name);

    $res1       = mysqli_query($connection, $query1);
    $count_resp = mysqli_fetch_array($res1);
    mysqli_free_result($res1);

    if ($count_resp && $count_resp['count'] > 0) {
        $res2 = mysqli_query($connection, $query2);

        $domain = '';

        while ($row = mysqli_fetch_assoc($res2)) {
            if (!$domain) {
                $domain = GetDomain($row['url']);
                $rf     = "$result_dir/$domain.csv";
                write_result_to_csv(array_keys($row), $rf);
            }

            write_result_to_csv($row, $rf);
        }

        echo "Exported {$count_resp['count']} rows from $table_name";
        echo "\n";
    } else {
        echo "$table_name doesn't have any data";
        echo "\n";
    }
}
echo '</pre>';

<?php

$base_dir    = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db-config.php';

header('Content-Type: text/csv; charset=utf-8');
header("Content-disposition: attachment; filename=\"all_car_data_script.csv\"");

$head = ['stock_number', 'vin', 'stock_type', 'title', 'year', 'make', 'model', 'trim', 'msrp', 'price', 'city', 'biweekly', 'lease', 'lease_term', 'lease_rate', 'finance', 'finance_term', 'finance_rate', 'price_history', 'body_style', 'engine', 'transmission', 'fuel_type', 'drivetrain', 'exterior_color', 'interior_color', 'kilometres', 'all_images', 'auto_texts', 'description', 'url', 'host', 'arrival_date', 'updated_at', 'handled_at', 'bing_handled_at', 'certified', 'deleted', 'options', 'custom'];

/*
 * Write the column name
 */
write_result($head);

/*
 * Connect Mysql
 */
$conn = new mysqli($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query     = "SELECT * FROM dealerships where status = 'active' OR status = 'trial' ";
$allDealer = $conn->query($query);
if ($allDealer) {
    while ($row = mysqli_fetch_array($allDealer)) {
        $dealer = $row['dealership'];
        $refine = checkRefine($dealer);

        /*
         * Remove some dealer
         */
        $remove_dealer_list = ['andreselectronicexperts'];

        if ($refine && !in_array($dealer, $remove_dealer_list)) {
            $tableName = $dealer . '_scrapped_data';

            /*
             * Remove rv dealer
             */
            if (strpos($tableName, 'rv_scrapped_data') !== false) {
                continue;
            }

            $query      = "SHOW TABLES LIKE  '$tableName'";
            $checkTable = $conn->query($query);

            if (mysqli_num_rows($checkTable)) {

                $query  = "SELECT * FROM $tableName WHERE deleted=0";
                $allCar = $conn->query($query);
                while ($row = mysqli_fetch_array($allCar)) {
                    /*
                     * Remove By words
                     * can't remove ev in their
                     */
                    $remove_by_keyWord = ['trailer', 'boat', 'cookie', 'pet', 'realestate'];
                    if (in_array(strtolower($row['url']), $remove_by_keyWord)) {
                        continue;
                    }

                    foreach ($head as $column) {
                        $data[$column] = $row[$column];
                    }
                    write_result($data);
                }
            }
        }
    }
}

/**
 * @param $dealer
 * @return string
 * Check Refine value
 */
function checkRefine($dealer)
{
    global $scrapper_configs;
    $refine = isset($scrapper_configs[$dealer]['refine']) ? $scrapper_configs[$dealer]['refine'] : 'true';

    return $refine;
}

/**
 * @param $data
 * Write in csv file
 */
function write_result($data)
{
    array_walk($data, function (&$value, $index) {
        $value = str_replace('"', '\'', $value);
        if (stripos($value, ',') !== false || stripos($value, "\n") !== false) {
            $value = "\"$value\"";
        }
    });
    echo implode(",", $data) . "\n";
}

<?php

require_once 'bootstrapper.php';

global $connection;

$db_connect = new DbConnect('all_imported');

$provinces = array(
    'AB' => 'Alberta',
    'BC' => 'British Columbia',
    'MB' => 'Manitoba',
    'NB' => 'New Brunswick',
    'NL' => 'Newfoundland and Labrador',
    'NS' => 'Nova Scotia',
    'NT' => 'Northwest Territories',
    'NU' => 'Nunavut',
    'ON' => 'Ontario',
    'PE' => 'Prince Edward Island',
    'QC' => 'Québec',
    'SK' => 'Saskatchewan',
    'YT' => 'Yukon'
);

header("Content-type:text/csv");
header("Content-Disposition: attachment; filename=\"Used cars by Province.csv\"");

csv_out(array(
    "Province",
    "Website",
    "Phone Numbers",
    "No. Used Cars"
));

foreach ($provinces as $state_code => $state_name) {
    $query1 = "SELECT host_name, address FROM imported_dealerships WHERE address LIKE '" . mysql_real_escape_string("%\"state_code\";s:2:\"$state_code\"%", $db_connect->con) . "'";

    $res1  = $db_connect->query($query1);
    $hosts = [];

    while ($row = mysql_fetch_array($res1)) {
        $hosts[$row['host_name']] = unserialize($row['address']);
    }

    foreach ($hosts as $host_name => $address) {
        $query2 = "SELECT count(stock_number) as car_count FROM all_imported_scrapped_data WHERE `host` = '$host_name' and stock_type = 'used'";

        $res2 = $db_connect->query($query2);
        $row  = mysql_fetch_array($res2);

        if ($row) {
            $car_count = $row['car_count'];

            $phones = isset($address['phones']) ? $address['phones'] : [];

            $phone_str = '';

            foreach ($phones as $phone) {
                if (stripos($phone_str, $phone) !== false) {
                    continue;
                }
                if ($phone_str != null) {
                    $phone_str .= ', ';
                }
                $phone_str .= $phone;
            }

            csv_out(array(
                $state_name,
                $host_name,
                $phone_str,
                $car_count
            ));
        }
    }
}

$db_connect->close_connection();

function csv_out($data) {
    $count = 0;
    foreach ($data as $value) {
        if ($count > 0) {
            echo ",";
        }
        echo "\"$value\"";
        $count++;
    }
    echo "\n";
}
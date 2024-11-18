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
    'QC' => 'Quebec',
    'SK' => 'Saskatchewan',
    'YT' => 'Yukon',
);

$make = isset($_GET['make']) ? $_GET['make'] : 'Ford';

header("Content-type:text/csv");
header("Content-Disposition: attachment; filename=\"Dealerships with $make.csv\"");

csv_out(array(
    "Province",
    "Website",
    "Phone Numbers",
));

$host_names = [];

$query = "SELECT distinct `host` FROM all_imported_scrapped_data WHERE stock_type = 'new' AND make = '$make'";

$res = $db_connect->query($query);

while ($row = mysql_fetch_array($res)) {
    $host_names[] = $row['host'];
}

$host_name_list = implode("', '", $host_names);

$query1 = "SELECT host_name, address FROM imported_dealerships WHERE host_name in ('$host_name_list')";

$res1 = $db_connect->query($query1);

while ($row = mysql_fetch_array($res1)) {
    $host_name = $row['host_name'];
    $address   = unserialize($row['address']);

    $phones    = isset($address['phones']) ? $address['phones'] : array();
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

    $state_name = $provinces[$address['state_code']];

    csv_out(array(
        $state_name,
        $host_name,
        $phone_str,
    ));
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

function csv_out($data)
{
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

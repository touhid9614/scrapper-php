<?php

require_once 'config.php';
require_once 'db_connect.php';
require_once 'utils.php';

global $connection;

$db_connect = new DbConnect('');
$country_code = filter_input(INPUT_GET, 'country_code') ? filter_input(INPUT_GET, 'country_code') : 'CA';
$query = "SELECT host_name, address FROM `imported_dealerships` WHERE address LIKE '%\"country_code\";s:2:\"$country_code\"%'";
$result = $db_connect->query($query);

header("Content-type:text/csv");
header("Content-Disposition: attachment; filename=\"Dealers in $country_code.csv\"");

echo "Domain,State,Phones\n";

while($row = mysqli_fetch_array($result)) {

    $host_name  = $row['host_name'];
    $address    = unserialize($row['address']);
    $state      = $address['state'];
    $phones     = $address['phones'];

    echo "$host_name,$state,\"" . implode(', ', $phones) . "\"\n";
}

$db_connect->close_connection();

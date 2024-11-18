<?php

require_once 'config.php';
require_once ADSYNCPATH . 'config.php';
require_once ABSPATH . 'includes/functions.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once 'includes/search-inventory.php';

function logme($data)
{}

global $connection, $distances, $CronConfigs;

secho("Trying to set timeout to no limit" . "<br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

$db_connect = new DbConnect('');

$query = "SELECT `host_name`, address from imported_dealerships where 1";

$result = $db_connect->query($query);

if (!$result) {
    echo mysqli_error($connection);
    die();
}

$data = array();

while ($row = mysqli_fetch_array($result)) {
    $host_name = $row['host_name'];
    $address   = unserialize($row['address']);

    if (isset($address['lat'])) {
        $lat  = $address['lat'];
        $long = $address['long'];

        $data[$host_name] = array(
            'lat'  => $lat,
            'long' => $long,
        );
    }
}

mysqli_free_result($result);

foreach ($data as $host_name => $loc) {
    $query = "UPDATE imported_dealerships SET `lat` = {$loc['lat']}, `long` = {$loc['long']} WHERE `host_name` = '$host_name';";
    $db_connect->query($query);
}

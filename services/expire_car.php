<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3/";

/* INCLUDE REQUIRED FILES */
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$dealership = filter_input(INPUT_GET, 'dealership');
$with_time  = isset($_GET['time']) ? true : false;

if (!$dealership) {
    echo "Need proper dealership";
    return;
}

if ($with_time) {
    $time  = time();
    $query = "UPDATE {$dealership}_scrapped_data SET deleted = true, deleted_at = {$time} WHERE deleted = 0;";
} else {
    $query = "UPDATE {$dealership}_scrapped_data SET deleted = true WHERE deleted = 0;";
}

try {
    DbConnect::get_instance()->query($query);
    echo "All cars in {$dealership}_scrapped_data is now marked as sold.";
} catch (Exception $ex) {
    echo "Error: " . $ex;
}

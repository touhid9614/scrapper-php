<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

$db_connect = new DbConnect('');
$query = "SELECT * FROM dealer_domain_meta_data WHERE meta_key not LIKE '%_profileId';";
$fetch = $db_connect->query($query);

$out = [];

while ($row = mysqli_fetch_assoc($fetch)) {
    $out[trim($row['meta_key'])] = trim(unserialize($row['meta_value']));
}

echo json_encode($out);
<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $scrapper_configs;

$out = [];

$db_connect = new DbConnect('');
$fetch      = $db_connect->query("SELECT dealership, websites, status FROM dealerships ORDER BY dealership ASC;");

while ($row = mysqli_fetch_assoc($fetch)) {
    $dealership      = $row['dealership'];
    $scrapper_config = $scrapper_configs[$dealership];

    if ($scrapper_config['vdp_url_regex']) {
        $vdp_url_regex = $scrapper_config['vdp_url_regex'];
    } else {
        $vdp_url_regex = '';
    }

    $out[] = [
        'domain_key'    => $dealership,
        'domain_name'   => $row['websites'],
        'status'        => $row['status'],
        'vdp_url_regex' => $vdp_url_regex
    ];
}

echo json_encode($out);
<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = $base_dir . "/adwords3/";
$data_dir    = $adwords_dir . '/data/marketcheck/';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$db_connect = new DbConnect('');
$key        = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$dealers    = [];
$existing   = [];
$result     = $db_connect->query("SELECT dealer_id FROM marketcheck_dealers");

while ($row = mysqli_fetch_assoc($result)) {
    $existing[] = $row['dealer_id'];
}

for ($id = 1000000; $id < 1103476; $id++) {
    if (in_array($id, $existing)) {
        continue;
    }

    $url               = "https://marketcheck-prod.apigee.net/v1/dealer/$id?api_key=$key";
    $data              = HttpGet($url);
    $data              = json_decode($data, true);
    $data['dealer_id'] = $data['id'];

    if (isset($data['inventory_url'])) {
        $new       = "https://marketcheck-prod.apigee.net/v1/search?api_key=$key&dealer_id=$id&car_type=new";
        $used      = "https://marketcheck-prod.apigee.net/v1/search?api_key=$key&dealer_id=$id&car_type=used";
        $cert      = "https://marketcheck-prod.apigee.net/v1/search?api_key=$key&dealer_id=$id&car_type=certified";
        $new_data  = json_decode(HttpGet($new), true);
        $used_data = json_decode(HttpGet($used), true);
        $cert_data = json_decode(HttpGet($cert), true);

        $data['new']       = isset($new_data['num_found']) ? $new_data['num_found'] : 0;
        $data['used']      = isset($used_data['num_found']) ? $used_data['num_found'] : 0;
        $data['certified'] = isset($cert_data['num_found']) ? $cert_data['num_found'] : 0;

        $data['total_cars'] = $data['new'] + $data['used'] + $data['certified'];

        $query_prep = $db_connect->prepare_query_params($data, DbConnect::PREPARE_PARENTHESES);
        $query      = "INSERT INTO marketcheck_dealers $query_prep";
        $db_connect->query($query);
    }
}

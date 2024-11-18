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
$cmd        = "INSERT";
$result     = $db_connect->query("SELECT dealer_id FROM marketcheck_dealers");

/* $new  = "https://marketcheck-prod.apigee.net/v1/search?api_key=" . $key . "&dealer_id=1000002&car_type=new";
$used = "https://marketcheck-prod.apigee.net/v1/search?api_key=" . $key . "&dealer_id=1000002&car_type=used";
$new_data  = json_decode(HttpGet($new), true);
$used_data = json_decode(HttpGet($used), true); */

while ($row = mysqli_fetch_assoc($result)) {
    $existing[] = $row['dealer_id'];
}

for ($id = 1000001; $id < 1103476; $id++) {
    if (in_array($id, $existing)) {
        $cmd = "UPDATE";
    }

    $url               = 'https://marketcheck-prod.apigee.net/v1/dealer/' . $id . '?api_key=' . $key;
    $data              = HttpGet($url);
    $data              = json_decode($data, true);
    $data['dealer_id'] = $data['id'];
}

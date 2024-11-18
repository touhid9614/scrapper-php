<?php

$base_dir    = dirname(__DIR__);
$adwords_dir = $base_dir . "/adwords3/";
$data_dir    = $adwords_dir . '/data/marketcheck/';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$db_connect = new DbConnect('');
$key        = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';

$selectQuary = "SELECT * FROM `marketcheck_dealers_v2` WHERE `country` = 'CA'";
$result      = $db_connect->query($selectQuary);

while ($row = mysqli_fetch_assoc($result)) {
    $id          = $row['dealer_id'];
    $used_owned  = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&car_type=used&owned=true&country=ca";
    $new_owned   = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&car_type=new&owned=true&country=ca";
    $total_owned = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&owned=true&country=ca";

    $used_data  = json_decode(HttpGet($used_owned), true);
    $new_data   = json_decode(HttpGet($new_owned), true);
    $total_data = json_decode(HttpGet($total_owned), true);

    $new_owned   = isset($new_data['num_found']) ? $new_data['num_found'] : 0;
    $used_owned  = isset($used_data['num_found']) ? $used_data['num_found'] : 0;
    $total_owned = isset($total_data['num_found']) ? $total_data['num_found'] : 0;

    $query_prep = $db_connect->prepare_query_params($data, DbConnect::PREPARE_PARENTHESES);
    $query      = "UPDATE marketcheck_dealers_v2 SET new_owned= '$new_owned', used_owned= '$used_owned', total_owned= '$total_owned' where  dealer_id = $id  ";
    echo $query;
    $db_connect->query($query);
}

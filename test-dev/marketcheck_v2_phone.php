<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";
$log_path    = "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2.log";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

$db_connect        = new DbConnect('');
$key               = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$marketcheck_table = "marketcheck_dealers_v2";

$query_v2  = "SELECT dealer_id FROM $marketcheck_table where recent_total_owned >0 and  seller_phone is null";
$result_v2 = $db_connect->query($query_v2);

while ($row_v2 = mysqli_fetch_assoc($result_v2)) {
    $dealer_id        = $row_v2['dealer_id'];
    $dealer_info      = "https://marketcheck-prod.apigee.net/v2/dealer/car/$dealer_id?api_key=$key";
    $dealer_info_data = json_decode(HttpGet($dealer_info), true);
    if ($dealer_info_data && $dealer_info_data['seller_phone']) {
        $update_query = "UPDATE $marketcheck_table SET seller_phone = '{$dealer_info_data['seller_phone']}' WHERE dealer_id = $dealer_id;";
        echo $update_query . '<br>';
        $db_connect->query($update_query);
    }
}

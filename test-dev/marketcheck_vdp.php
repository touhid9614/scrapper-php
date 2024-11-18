<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = $base_dir . "/adwords3/";
// $data_dir       = $adwords_dir . '/data/marketcheck/';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

global $proxy_list;

$marketchek_table = "marketcheck_dealers_v2";

$start_id = isset($_GET['start_id']) ? filter_input(INPUT_GET, 'start_id') : false;

$db_connect = new DbConnect('');
$key        = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$existing   = [];
$query      = "SELECT dealer_id FROM $marketchek_table WHERE vdp IS NULL;";

if ($start_id) {
    $query = "SELECT dealer_id FROM $marketchek_table WHERE (total_owned > 0 AND vdp IS NULL AND dealer_id > '$start_id');";
}

$result = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($result)) {
    $existing[] = $row['dealer_id'];
}

foreach ($existing as $id) {
    $url  = "https://marketcheck-prod.apigee.net/v1/search?api_key=$key&dealer_id=$id";
    $data = HttpGet($url, $proxy_list);
    $data = json_decode($data, true);
    $vdp  = isset($data['listings']) ? urlencode($data['listings'][0]['vdp_url']) : null;

    if ($vdp) {
        $query = "UPDATE $marketchek_table SET vdp='$vdp' WHERE dealer_id='$id';";
        $db_connect->query($query);
        // echo $query;
        // break;
    }
}

$db_connect->close_connection();

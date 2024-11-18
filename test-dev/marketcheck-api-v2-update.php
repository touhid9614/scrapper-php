<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = $base_dir . "/adwords3/";
$data_dir    = $adwords_dir . '/data/marketcheck/';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$db_connect       = new DbConnect('');
$key              = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$req_count        = 0;
$dealer_req_count = 0;

// $query = "SELECT dealer_id,seller_name,inventory_url FROM marketcheck_dealers_v2 WHERE seller_name LIKE '%nissan%' OR inventory_url LIKE '%nissan%'";
$query  = "SELECT dealer_id, country, seller_name, inventory_url FROM marketcheck_dealers_v2;";
$result = $db_connect->query($query);
$i      = 1;

while ($record = mysqli_fetch_assoc($result)) {
    $data = array();
    $id   = $record['dealer_id'];
    if ($record['country'] == 'CA') {
        $used_owned  = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&car_type=used&owned=true&country=ca";
        $new_owned   = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&car_type=new&owned=true&country=ca";
        $total_owned = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&owned=true&country=ca";
    } else {
        $used_owned  = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&car_type=used&owned=true";
        $new_owned   = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&car_type=new&owned=true";
        $total_owned = "https://marketcheck-prod.apigee.net/v2/search/car/active?api_key=$key&dealer_id=$id&owned=true";
    }
    $req_count += 3;

    $used_data  = json_decode(HttpGet($used_owned), true);
    $new_data   = json_decode(HttpGet($new_owned), true);
    $total_data = json_decode(HttpGet($total_owned), true);

    $recent_new_owend   = isset($new_data['num_found']) ? $new_data['num_found'] : 0;
    $recent_used_owned  = isset($used_data['num_found']) ? $used_data['num_found'] : 0;
    $recent_total_owned = isset($total_data['num_found']) ? $total_data['num_found'] : 0;

    $query = "UPDATE marketcheck_dealers_v2 SET recent_new_owend = '$recent_new_owend', recent_used_owned = '$recent_used_owned', recent_total_owned = '$recent_total_owned' WHERE dealer_id = $id";
    $db_connect->query($query);
    //    echo $i.'. '.$query .'<br>';
    $i++;
}

echo "<br>Total request : $req_count <br>";

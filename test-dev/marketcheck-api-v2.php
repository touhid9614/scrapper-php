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
$table_name       = 'marketcheck_dealers_v2';
$key              = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$req_count        = 0;
$dealer_req_count = 0;

// $vehicle_type = 'car';
// $vehicle_type = 'rv';
$vehicle_type = 'motorcycle';
// $vehicle_type = 'heavy-equipment';

switch ($vehicle_type) {
    case 'car':
        $start = 1000002;
        $end   = 1104775;
        break;
    case 'rv':
        $start = 5689;
        $end   = 7111;
        break;
    case 'motorcycle':
        $start = 2593;
        $end   = 5688;
        break;
    case 'heavy-equipment':
        $start = 10819;
        $end   = 12686;
        break;
}

for ($id = $start; $id <= $end; $id++) {
    $query  = "SELECT dealer_id FROM {$table_name} WHERE `dealer_id` = $id;";
    $result = $db_connect->query($query);

    if (mysqli_num_rows($result) == 0) {
        $dealer_info = "https://marketcheck-prod.apigee.net/v2/dealer/{$vehicle_type}/{$id}?api_key={$key}";
        $dealer_req_count++;
        $dealer_info_data = json_decode(HttpGet($dealer_info), true);

        if ($dealer_info_data) {
            $data                 = [];
            $data                 = $dealer_info_data;
            $data['dealer_id']    = $data['id'];
            $data['vehicle_type'] = $vehicle_type;

            if ($data['status'] == 'active') {
                /*$used_owned  = "https://marketcheck-prod.apigee.net/v2/search/{$vehicle_type}/active?api_key=$key&dealer_id=$id&car_type=used&owned=true";
                $new_owned   = "https://marketcheck-prod.apigee.net/v2/search/{$vehicle_type}/active?api_key=$key&dealer_id=$id&car_type=new&owned=true";
                $total_owned = "https://marketcheck-prod.apigee.net/v2/search/{$vehicle_type}/active?api_key=$key&dealer_id=$id&owned=true";
                $req_count += 3;

                $used_data  = json_decode(HttpGet($used_owned), true);
                $new_data   = json_decode(HttpGet($new_owned), true);
                $total_data = json_decode(HttpGet($total_owned), true);

                $data['new_owned']   = isset($new_data['num_found']) ? $new_data['num_found'] : 0;
                $data['used_owned']  = isset($used_data['num_found']) ? $used_data['num_found'] : 0;
                $data['total_owned'] = isset($total_data['num_found']) ? $total_data['num_found'] : 0;*/

                $query_prep = $db_connect->prepare_query_params($data, DbConnect::PREPARE_PARENTHESES);
                $query      = "INSERT INTO {$table_name} {$query_prep}";
                $db_connect->query($query);
            } else {
                $query_prep = $db_connect->prepare_query_params($data, DbConnect::PREPARE_PARENTHESES);
                $query      = "INSERT INTO {$table_name} {$query_prep}";
                $db_connect->query($query);
            }
        }
    }
}

echo "Dealer Total request : $dealer_req_count <br>";
echo "Total vdp request : $req_count <br>";

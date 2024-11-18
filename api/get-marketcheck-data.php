<?php

header("Access-Control-Allow-Origin: *");

$base_path = dirname(__DIR__);
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';

$db_connect   = new DbConnect();
$mc_dealer_id = isset($_GET['id']) ? $_GET['id'] : false;
$result       = [];

$result['success'] = false;
$result['data']    = [];

if ($mc_dealer_id) {
    $res = $db_connect->query("SELECT * from marketcheck_dealers_v2 WHERE dealer_id = {$mc_dealer_id};");

    if (mysqli_num_rows($res)) {
        $result['success'] = true;
        $result['data']    = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $result['message'] = 'No data found.';
    }

} else {
    $result['message'] = 'Not a valid request. No Id found';
}

echo json_encode($result);
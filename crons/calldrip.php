<?php

require_once dirname(__DIR__) . '/dashboard/budgetchecker/config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

// get all dealership which has call drip feature
$db_connect  = new DbConnect('');
$dealer_info = $db_connect->get_all_dealers("`calldrip` = '1'");

foreach ($dealer_info as $key => $dealer) {
    $calldrip_data    = $db_connect->get_all_pending_calldrip_data("`dealership` = '$key' and `updated_at` is null");
    $salesman_info    = $dealer['salesman_numbers'];
    $salesman_numbers = [];

    foreach ($salesman_info as $salesman) {
        $start_time   = DateTime::createFromFormat('H: i', $salesman['start_time']);
        $end_time     = DateTime::createFromFormat('H: i', $salesman['end_time']);
        $current_time = new DateTime();

        if ($current_time >= $start_time && $current_time <= $end_time) {
            array_push($salesman_numbers, $salesman['number']);
        }
    }

    if (count($salesman_numbers) > 0) {
        foreach ($calldrip_data as $calldrip) {
            calldripApiRequest($salesman_numbers, $calldrip['lead_id'], $calldrip['interest'], $calldrip['price'], $calldrip['number']);
            $db_connect->update_pending_calldirp_data($salesman_numbers, $calldrip['lead_id']);
        }
    }
}
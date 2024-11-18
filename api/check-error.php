<?php

$base_path = dirname(__DIR__);
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'utils.php';

$service = isset($_GET['service']) ? $_GET['service'] : 'analytics';

$post_url = (isset($_GET['api']) && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-dev.smedia.ca/v1';
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';


$get_all_dealer_id = $post_url . "/get-all-dealer-info-id";
$res = HttpGet($get_all_dealer_id, false, false, '', $nothing, 'application/json', $additional_headers);
$dealerships = json_decode($res);

echo "<pre>";
echo "API:: $post_url<br>";
echo "Service:: $service<br>";
echo "********************************<br><br>";

foreach ($dealerships as $dealer) {
	if($dealer->status){
		$dealer_id = $dealer->dealershipId;
		$dealer_name = $dealer->dealerName;
		$cron = $dealer->cron;
		echo "Dealer ID:: $dealer_id <br>";
		echo "Dealer:: $dealer_name <br>";
		echo "Cron:: $cron <br>";

		$check_data_url = $post_url . "/dealer-data/$dealer_id/$service";
		$res = HttpGet($check_data_url, false, false, '', $nothing, 'application/json', $additional_headers);
		$dealerships_data = json_decode($res);

//		print_r($dealerships_data);
//		echo "<br>";
		if($dealerships_data->duplicate_data){
			echo "Their Are multiple data with same month.<br>";
			print_r($dealerships_data->duplicate_month);
			echo "<br>";
		}


		echo "=========================<br><br>";
	}

}

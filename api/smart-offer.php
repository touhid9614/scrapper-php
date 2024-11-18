<?php
error_reporting(E_ERROR | E_PARSE);
$base_path = dirname(__DIR__);
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

$post_url = 'https://api.smedia.ca/v1';

if (isset($_GET['api'])) {
	if ($_GET['api'] == 'dev') {
		$post_url = 'https://api-dev.smedia.ca/v1';
	} else if ($_GET['api'] == 'local') {
		$post_url = 'localhost:3000/v1';
	}
}

$debug = (isset($_GET['debug']) && $_GET['debug']) ? true : false;
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';


$get_all_smart_offer = $post_url . "/so-master-list";
$res = HttpGet($get_all_smart_offer, false, false, '', $nothing, 'application/json', $additional_headers);
$all_so = json_decode($res);
$all_smart_offer = $all_so->data->config;

$today = date("Y-m-d");

if ($debug) {
	echo "Server :: $post_url <br>";
	echo "Today :: $today <br>";
	echo "========================<br><br>";
}

for ($i = 0; $i < count($all_smart_offer); $i++) {

	$dealerId = $all_smart_offer[$i]->dealerId;
	$dealerName = $all_smart_offer[$i]->dealerName;
	$dealerActive = $all_smart_offer[$i]->active;
	$dealerServiceStatus = $all_smart_offer[$i]->soServiceStatus;
	$live = $all_smart_offer[$i]->live;
	$archive = $all_smart_offer[$i]->archive;
	$soName = $all_smart_offer[$i]->name;
	$start_date = $all_smart_offer[$i]->start_date;
	$end_date = $all_smart_offer[$i]->end_date;
	$config = $all_smart_offer[$i]->config;
	$old_config = $all_smart_offer[$i]->config;

	$post_so = false;

	if ($dealerActive && $dealerServiceStatus && !$archive) {
		if ($debug && ($start_date || $end_date)) {
			echo "Dealer ID:: $dealerId <br>";
			echo "Dealer Name:: $dealerName <br>";
		}

		if ($start_date) {
			$sd = date('Y-m-d', strtotime($start_date));
			if ($debug) {
				echo "SD:: $start_date <br>";
				echo "Php SD:: $sd <br>";
			}
			if (($today == $sd) && !$config->live) {
				$config->live = true;
				$post_so = true;
				if ($debug) {
					echo "Today Start Date<br>";
				}
			}
		}

		if ($end_date) {
			$ed = date('Y-m-d', strtotime($end_date));
			if ($debug) {
				echo "------<br>";
				echo "ED:: $end_date <br>";
				echo "Php ED:: $ed <br>";
			}
			if (($today == $ed) && $config->live ) {
				$config->live = false;
				$post_so = true;
				if ($debug) {
					echo "Today End Date<br>";
				}
			}
		}

		if ($post_so) {
			$post_data = json_encode($config);
//			echo $post_data;
			$post_url_sm_config = $post_url . '/sm-config/' . $dealerId;
			$res = HttpPost($post_url_sm_config, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
//			echo "Smart offer post<br>";
			$post_res = json_decode($res);

			if($post_res->success){
				if($config->live){
					$message = "This smart offer has been auto-published based on the set schedule date $sd";
					$messageList = "$soName has been auto-published based on the set schedule date $sd";
				} else {
					$message = "This smart offer has been turn off based on the set schedule date $ed";
					$messageList = "$soName has been turn off based on the set schedule date $ed";
				}

				if ($debug) {
					echo "Log Post:: $message<br>";
				}

				$log = array(
					"userName" => "System bot",
					"service" => "smart-offer",
					"dealerId" => $dealerId,
					"operation" => $message,
					"newData" => $config,
					"oldData" => $old_config
				);

				$post_data = json_encode($log);
				$post_url_dealer_info = $post_url . '/service-log';
				$res = HttpPost($post_url_dealer_info, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);

				$log = array(
					"userName" => "System bot",
					"service" => "smart-offer-list",
					"dealerId" => $dealerId,
					"operation" => $messageList,
					"newData" => $config,
					"oldData" => $old_config
				);

				$post_data = json_encode($log);
				$post_url_dealer_info = $post_url . '/service-log';
				$res = HttpPost($post_url_dealer_info, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
			}

		}

		if ($debug && ($start_date || $end_date)) {
			echo "<br>======================<br><br>";
		}
	}
}

?>


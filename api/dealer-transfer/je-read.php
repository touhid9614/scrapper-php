<?php

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'utils.php';


$post_url = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-qa.smedia.ca/v1';
echo "Post URL :: $post_url <br>";
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';


$jerret = [];
$jerret_cron = [];

$file = fopen('../dir.csv', 'r');
$count = 1;

while (($line = fgetcsv($file)) !== FALSE) {

	if ($count > 1) {
		$dealer_info = array();
		$dealer_info['guid'] = $line[0];
		$dealer_info['name'] = $line[1];
		$dealer_info['domain'] = $line[34];
		$dealer_info['cron'] = $cron = $line[15];
		$dealer_info['id'] = $line[2];
		$dealer_info['email'] = $email = $line[7];
		$dealer_info['aid'] = $line[16];
		$dealer_info['epid'] = $line[5];
		$dealer_info['viewId'] = $line[9];
		$dealer_info['fbId'] = (string)$line[10];
		$dealer_info['fbpixel'] = (string)$line[17];
		$dealer_info['google'] = $line[3];
		$dealer_info['bing'] = $line[13];
		$dealer_info['bingad'] = $line[12];
		$dealer_info['csm'] = $line[24];
		$dealer_info['googleAdOps'] = $line[25];
		$dealer_info['fbAdsOps'] = $line[26];

		$dealer_info['account'] = str_replace("@gmail.com", "", $email);

		if ($cron) {
			array_push($jerret, $dealer_info);
			$jerret_cron[$cron] = $dealer_info;
		}
	}

	$count++;
}

fclose($file);

echo "<pre>";
//print_r($jerret);

foreach ($jerret as $je){
	$cron = $je['cron'];
	echo "Dealer Name: ".$cron."<br>";
	$check_dealer = $post_url . "/dealer-by-cron/$cron";
	$res                 = HttpGet($check_dealer, false, false, '', $nothing, 'application/json', $additional_headers);
	$checkDealerRes = json_decode($res);

	if($checkDealerRes->success){
		$id = $checkDealerRes->id;
		$fbId = $je['fbId'] ? $je['fbId'] : false;
		if($fbId){
			$finalObject = [];
			$finalObject = array(
				"idNo"    => $fbId,
			);

			$post_data       = json_encode($finalObject);
			$post_url_dealer = $post_url . "/dealer/$id/fb";
			$res             = HttpPost($post_url_dealer, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
			echo "Dealer Id: $id<br>";
			echo $res. "<br>";
		}
	} else {
		echo "Dealer Not In Mongo<br>";
	}

	echo "<br><br>============================<br><br>";

}

?>

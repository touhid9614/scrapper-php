<?php
ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

//$post_url = (isset($_GET['api']) && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-dev.smedia.ca/v1';
$post_url = 'localhost:3000/v1';
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';


echo '<pre>';
echo '<b>' . $post_url . "</b><br><br>";

$my_debug = filter_input(INPUT_GET, 'my_debug') == '1';

$post_url_dealer_id_pull = $post_url . "/get-all-dealer-info";
$res = HttpGet($post_url_dealer_id_pull, false, false, '', $nothing, 'application/json', $additional_headers);
$dealerships = json_decode($res);

//print_r($res);
$count = 1;
foreach ($dealerships as $dealer){
	echo "Count:: $count <br>";
	echo "Group Id: " . $dealer->groupId . '<br>';
	echo "Group Name: " . $dealer->group . '<br>';
	echo "Group status: " . ($dealer->groupStatus ? 'True' : 'False') . '<br>';
	echo "Dealership Id: " . $dealer->dealershipId . '<br>';
	echo "Dealer Name: " . $dealer->dealerName . '<br>';
	echo "Domain: " . $dealer->domain . '<br>';
	echo "Cron: " . $dealer->cron . '<br>';
	echo "Status: " . ($dealer->status ? 'True' : 'False') . '<br>';
	echo "<br>=======================<br>";
	$count++;
	$id = $dealer->dealershipId;

	$finalObject = array(
		"active" => $dealer->groupStatus ?  true : false
	);

	$post_data = json_encode($finalObject);
	$post_url_dealer = $post_url . "/dealer/$id";
	$res = HttpPost($post_url_dealer, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);

	echo  "Response: ".$res ." <br>";
	echo "<br>=======================<br>";

}

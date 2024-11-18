<?php
ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';


global $CronConfigs, $CurrentConfig;

$post_url = (isset($_GET['api']) && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-dev.smedia.ca/v1';
//$post_url = "localhost:3000/v1";
echo '<pre>';
//echo '<b>' . $post_url . "</b><br>";

$dealer = [
	"www.amarillohyundai.com",
	"www.401dixiehyundai.com",
	"www.417nissan.com",
	"www.abbotsfordvw.ca",
	"www.audiwinnipeg.com",
	"www.bmwmontrealcentre.ca",
	"www.bridgesgm.com",
	"www.cambridgehyundai.com",
	"www.capitaljeep.com",
	"www.chilliwackvw.ca",
	"www.courtesychrysler.com",
	"www.crosstownautocentre.com",
	"www.crosstownautocentre.com",
	"www.crowfoothyundai.com",
	"www.easternchrysler.com",
	"www.fishcreeknissancalgary.ca",
	"www.gphyundai.com",
	"www.gpnissan.ca",
	"www.gpsubaru.com",
	"www.gpvolkswagen.ca",
	"www.guelphhyundai.com",
	"www.huntclubnissan.com",
	"www.hyattinfiniticalgary.com",
	"www.islandgm.com",
	"www.mannnorthway.ca",
	"www.mapleridge-vw.ca",
	"www.mcnaught.com",
	"www.monctonchrysler.com",
	"www.northlanddodge.ca",
	"www.northland-hyundai.ca",
	"www.northlandnissan.com",
	"www.northland-vw.ca",
	"www.parklanddodge.com",
	"www.smpchev.ca",
	"www.sphyundai.com",
	"www.sherwoodpark-vw.ca",
	"www.stjamesvw.com",
	"www.towerchrysler.com",
	"www.bannisters.com",
	"www.bannisterhonda.com",
	"www.basswoodcdjr.com",
	"www.byrider.com",
	"www.campkins.com",
	"cittecenter.com",
	"www.coastmountaingm.com",
	"cookford.com",
	"www.covingtonhondanissan.com",
	"drivetimeontario.ca",
	"www.enstoyota.ca",
	"www.erinmillsmazda.ca",
	"www.frankdunntrailersales.com",
	"www.freedombg.com",
	"www.greatnorthgm.ca",
	"www.huntermotors.ca",
	"www.kelownachev.com",
	"www.bradleygm.com",
	"www.lakewoodchev.com",
	"lauriahyundai.com",
	"www.lauriavolkswagen.com",
	"www.ledinghamgm.com",
	"www.lindsaygm.ca",
	"lussiersales.com",
	"www.mainlinechrysler.ca",
	"www.motorinnautogroup.com",
	"www.murrayhyundaimedicinehat.com",
	"www.nissanofmidland.com",
	"www.fortwaynenissan.com",
	"www.lexusofarlington.com",
	"www.lexusofftwayne.com",
	"www.princealberttoyota.ca",
	"prioritytoyotaspringfield.com ",
	"www.reliablemotors.ca",
	"www.royfosswoodbridge.com",
	"www.rvsuperstoresaskatoon.com",
	"www.stephenwadenissan.com",
	"www.tamiamihyundai.com",
	"www.thompsonford.ca",
	"www.hi-linedodge.com",
	"www.tillemanmotor.com",
	"www.titanauto.ca",
	"www.toyotaofwf.com",
	"www.tri-stateford.com",
	"www.wheatonchev.com",
	"www.whitescanyonford.com",
	"www.whitewatermotors.com",
	"www.winegardford.com ",
	"www.woodwheaton.com",
	"www.woodwheatonhonda.ca"];

//$dealer = ["www.aachevy.com"];
$db_connect = new DbConnect();
$i = 1;
foreach ($dealer as $domain) {
	$post_url_dealer_id_pull = $post_url . "/dealer-exist/$domain";
	$res = HttpGet($post_url_dealer_id_pull);
	$dealerships = json_decode($res);
	echo "Count: $i <br>";
	$i++;
	$dealer_exist = $dealerships->dealer;
	if ($dealer_exist) {
		$cron = $dealerships->cron;
		$id = $dealerships->dealershipId;
		echo "ID: $id <br>Cron: $cron <br>=================<br><br>";


		$query = "select * from smart_offer_customer_views WHERE dealership ='$cron' ORDER by id DESC";
		$submit_data = $db_connect->query($query);

		$post_data = [];

		while ($row = mysqli_fetch_assoc($submit_data)) {
			$uuid = $row['uuid'];
			$count = $row['count'];
			$at = $row['at'];
			$at_array = unserialize($at);
			foreach ($at_array as $dt) {
				$max_at = date('Y-m-d', $dt);
				$date = str_replace('-', '', substr($max_at, 0, 10));
				if($date > 20200000) {
					if (array_key_exists($date, $post_data)) {
						if (array_key_exists($uuid, $post_data[$date])) {
							$post_data[$date][$uuid] += 1;
						} else {
							$post_data[$date][$uuid] = 1;
//						$post_data[$date]['total-uuid'] += 1;
						}
					} else {
						$post_data[$date][$uuid] = 1;
//					$post_data[$date]['total-uuid'] = 1;
//					$post_data[$date]['total-co'] = 0;
					}
				}
//				$post_data[$date]['total-co'] += 1;
//				if($date > 20210800) {
//					$myObj = array();
//					$myObj['date'] = $date;
//					$myObj['action'] = "view";
//					$myObj['service'] = "smart-offer";
//					$myObj['uuid'] = $uuid;
//					$myObj['session'] = '';
//					$myObj['url'] = '';
//
//					$post_data = json_encode($myObj);
//
//					echo "Post Data : ";
//					print_r($post_data);
//
//					$post_url_data_push = $post_url . "/smart-offer/$id";
//					$res = HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json');
//
//					echo "<br>Res : ";
//					print_r($res);
//					echo "<br>.....................<br>";
//				}

			}

//			if ($count > 4) {
//				$max_at = date('Y-m-d', $at_array[0]);
//				$date = str_replace('-', '', substr($max_at, 0, 10));
//
//				$myObj = array();
//				$myObj['date'] = $date;
//				$myObj['action'] = "view";
//				$myObj['service'] = "smart-offer";
//				$myObj['uuid'] = $uuid;
//				$myObj['session'] = '';
//				$myObj['url'] = '';
//
//				for ($i = 4; $i < $count; $i++) {
//					$post_data = json_encode($myObj);
//
//					echo "Post Data : ";
//					print_r($post_data);
//					echo "<br>.....................<br>";
//
//					$post_url_data_push = $post_url . "/smart-offer/$id";
//					$res = HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json');
//
//					echo "<br>Res : ";
//					print_r($res);
//					echo "<br>-------------------------<br><br>";
//				}
//
//			}
//			echo "<br>-------------------------<br><br>";
		}


//		print_r($post_data);
		foreach ($post_data as $date => $pd) {
			echo "Date : $date <br>";
//			print_r($pd);
			$myObj = array();
			$myObj['date'] = $date;
			$myObj['data'] = $pd;
			$post_data = json_encode($myObj);

			echo "Post Data : ";
			print_r($post_data);
			$post_url_data_push = $post_url . "/smart-offer/bulk/$id";
			$res = HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json');

			echo "<br>Res : ";
			print_r($res);
			echo "<br>-------------------------<br><br>";
		}
	} else {
		echo "Dealer not exist in Mongo. Domain : $domain <br>=================<br><br>";
	}

	echo "<br><br>+++++++++++++++++++++++++++++<br><br>";
}





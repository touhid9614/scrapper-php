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

		//$query="SELECT socf.uuid,socfd.url,socfd.`datetime`,socfd.client_ip from smart_offer_customer_fillups as socf join smart_offer_customers_fillups_data as socfd ON socf.uuid=socfd.uuid where socf.dealership='$cron' order by socf.id desc limit 1";


		$query = "SELECT socf.uuid,socfd.url,socfd.`datetime`,socfd.client_ip,soc.name,soc.email, soc.phone from smart_offer_customer_fillups as socf left join smart_offer_customers_fillups_data as socfd ON socf.uuid=socfd.uuid left join smart_offer_customers as soc ON socf.uuid=soc.uuid  where socf.dealership='$cron' and socfd.dealership='$cron' and socf.uuid !='null' and socf.uuid IS not null order by socf.id desc ";

		$submit_data = $db_connect->query($query);

		while ($row = mysqli_fetch_assoc($submit_data)) {
			$uuid = $row['uuid'];
			$url = $row['url'];
			$datetime = $row['datetime'];
			$client_ip = $row['client_ip'];
			$name = $row['name'];
			$phone = $row['phone'];
			$email = $row['email'];
			$date = str_replace('-', '', substr($datetime, 0, 10));
			if($date > 20200000) {
				$myObj = array();
				$myObj['date'] = $date;
				$myObj['action'] = "submit";
				$myObj['service'] = "smart-offer";
				$myObj['uuid'] = $uuid;
				$myObj['url'] = $url;
				$myObj['ip'] = $client_ip;
				$myObj['name'] = $name;
				$myObj['email'] = $email;
				$myObj['phone'] = $phone;
				$post_data = json_encode($myObj);

				echo "Post Data : ";
				print_r($post_data);

				$post_url_data_push = $post_url . "/smart-offer/$id";
				$res = HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json');

				echo "<br>Res : ";
				print_r($res);
				echo "<br>-------------------------<br><br>";
			}
		}


	} else {
		echo "Dealer not exist in Mongo. Domain : $domain <br>=================<br><br>";
	}

	echo "<br><br>+++++++++++++++++++++++++++++<br><br>";
}





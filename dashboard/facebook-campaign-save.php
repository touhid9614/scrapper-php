<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';
require_once 'facebook/fb-data.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$db_connect = new DbConnect();

$accid= $_POST['accid'];
$dealership= $_POST['dealer'];
$prefix = $_POST['prefix'];
$objectives = $_POST['objectives'];
$audience = $_POST['audience'];
$adformats = $_POST['adformats'];
$aged = $_POST['aged'];
$inventory = $_POST['inventory'];
$postfix = $_POST['postfix'];
$name = $_POST['name'];
$customfeed = $_POST['customfeed'];
$utmprefix = $_POST['utmprefix'];
$utmpostfix = $_POST['utmpostfix'];
$fbObjective = $_POST['fbObjective'];
$special_ad_category = $_POST['special_ad_category'];
$budgetType = $_POST['budgetType'];
$budgetAmount = $_POST['budgetAmount'];
$bid_strategy = $_POST['bid_strategy'];



$query = "INSERT INTO dealer_facebook_campaign
    (dealership,account_id, prefix, objectives, audience, adformats, aged, inventory, postfix, name, utmprefix,
     customfeed, utmpostfix ,fbObjective, special_ad_category, budgetType, budgetAmount, bid_strategy)
VALUES ('$dealership', '$accid' ,'$prefix', '$objectives', '$audience', '$adformats', '$aged', '$inventory', '$postfix',
        '$name', '$utmprefix', '$customfeed', '$utmpostfix', '$fbObjective', '$special_ad_category', '$budgetType',
        '$budgetAmount', '$bid_strategy')";

//echo $query;

if ($db_connect->query($query) === TRUE) {

	if ($dealership == 'titanauto'){
		$last_id_query = "SELECT id FROM `dealer_facebook_campaign` ORDER BY `id` DESC LIMIT 1";
		$result =  $db_connect->query($last_id_query);
		$row = $result -> fetch_array();
		$last_id = $row["id"];

		$fb_campaign_id = createFBCampaign($accid,$name,$fbObjective,$bid_strategy,$special_ad_category,$budgetType,$budgetAmount);

		if(isset($fb_campaign_id['id'])){
			$camp_id = $fb_campaign_id['id'];
			$update_query = "UPDATE dealer_facebook_campaign SET campaign_id=$camp_id , campaign_save_fb = 1 WHERE id=$last_id ";
			$db_connect->query($update_query);
		}
	}

}





//header("Location: /facebook-campaign.php");

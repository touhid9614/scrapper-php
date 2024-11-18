<?php

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';


$ACCESS_TOKEN = "EAAXF5p9kawwBAC2V7U6SFxZB9IMiJcEZCgqsQmL2hO9cY6BDLUG5zTBe1GkJx5zZB7vNsnxWQE8M0ebjHpNEZAZCApzqdM5XDxykqEQlBOhZAHNsBtzaG8ZA1tPL0OLPhyM7ktT2j5V951qxaeCMd74MGZArHKZBrRz8D5F4ZALpH9vOZA7icA6EY8F";
$APP_SECRET = "ff8bee697d0d4dde38e7f15461700258";
$APP_ID = "1624969190861580";
$AD_ACCOUNT_ID = "act_479465702906861";

$fb = new Facebook\Facebook([
	'app_id' => $APP_ID,
	'app_secret' => $APP_SECRET,
	'default_graph_version' => 'v9.0',
	'default_access_token' => $ACCESS_TOKEN
]);


/** Important Link */
/*
 * https://developers.facebook.com/docs/php/Facebook/5.0.0
 * https://developers.facebook.com/docs/marketing-api/reference/ad-account/campaigns/
 * https://developers.facebook.com/tools/explorer/?method=GET&path=act_479465702906861%2Fcampaigns%3Ffields%3Dname%2Cstatus%2Cdaily_budget%2Clifetime_budget%2Cbudget_remaining%2Cstart_time%2Cupdated_time%2Cbid_strategy%26limit%3D500&version=v9.0
 *
 * https://github.com/facebookarchive/php-graph-sdk/tree/master/docs
 * https://github.com/facebookarchive/php-graph-sdk/blob/5.x/docs/reference/GraphNode.md
 * https://github.com/facebookarchive/php-graph-sdk/blob/master/docs/reference/GraphEdge.md
 */


function getLoginUser()
{
	global $fb;
	try {
		// Get the \Facebook\GraphNodes\GraphUser object for the current user.
		// If you provided a 'default_access_token', the '{access-token}' is optional.
		$response = $fb->get('/me');
	} catch (\Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch (\Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	echo "<pre><br>=============================<br>";
	print_r($response);
	echo "</pre>";

	$me = $response->getGraphUser();
	return 'Logged in as ' . $me->getName();
}

//echo getLoginUser($fb);
//exit;

function getAllCampaigns($adAccountId)
{
	global $fb;
	try {
		// Returns a `Facebook\FacebookResponse` object

//		$response = $fb->get(
//			"/$adAccountId/campaigns?fields=name,status,daily_budget,lifetime_budget,budget_remaining,start_time,updated_time,bid_strategy,adsets{name,status,ads{id,name,status}}&limit=500"
//		);
		$response = $fb->get(
			"/$adAccountId/campaigns?fields=name,status,daily_budget,lifetime_budget,budget_remaining,start_time,updated_time,bid_strategy,objective,special_ad_categories,promoted_object&limit=500"
		);
	} catch (Facebook\Exceptions\FacebookResponseException $e) {
		echo '<br>Graph returned an error: ' . $e->getMessage();
		exit;
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		echo '<br>Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

//	echo "<pre><br>=============================<br>";
//	print_r($response);
//	echo "</pre>";


	$graphEdge = $response->getGraphEdge();
	$allCampaign = [];
	foreach ($graphEdge as $graphNode) {
		$data = $graphNode->asArray();
		array_push($allCampaign, $data);
//		echo "<pre><br>=============================<br>";
//		print_r($data);
//		echo "</pre>";
	}
	return $allCampaign;

//	$data = $graphNode['items'];
//
//	echo "<pre><br>=============================<br>";
//	print_r($data);
//	echo "</pre>";
}

//getAllCampaigns($fb, $AD_ACCOUNT_ID);


function getAccountId($pixel_id)
{
	$strJsonFileContents = file_get_contents("facebook/account_id.json");
	$array = json_decode($strJsonFileContents, true);
	echo count($array);
	foreach ($array as $dealer) {
		if ($dealer['id'] == $pixel_id) {
			return $dealer['owner_ad_account']['id'];
		}
	}
	return false;

}

//echo getAccountId('1689710047977497');

function createFBCampaign($adAccountId, $name, $objective , $bid_strategy, $special_ad_categories, $budgetType, $budgetAmount, $status = 'PAUSED')
{

	global $fb;

	$special_ad_categories_array = explode(',',$special_ad_categories);


	$data = array(
		'name' => $name,
		'bid_strategy' => $bid_strategy,
		'objective' => $objective,
		'status' => $status,
		'special_ad_categories' => $special_ad_categories_array,
		"$budgetType" => $budgetAmount
	);

//	echo '<pre>';
//	print_r($data);
//	echo '</pre>';

	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post(
			"/$adAccountId/campaigns",
			$data
		);;
	} catch (Facebook\Exceptions\FacebookResponseException $e) {

		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
//	echo "<pre><br>=============================<br>";
//	print_r($response);
//	echo "</pre>";
	$graphNode = $response->getGraphNode();
	return $graphNode->asArray();
}


//echo "<br><br>".createFBCampaign('act_999138520297362','sMedia Dynamic Lead Lookalike-titanauto_Vehicle_ALL SEGMENTS');


function updateFBCampaign($campaignId,  $status = false, $bid_strategy = false, $budgetType = false, $budgetAmount = false, $name = false )
{

	global $fb;
	$updateData = [];
	if($name){
		$updateData['name'] = $name ;
	}
	if($status){
		$updateData['status'] = $status ;
	}
	if($bid_strategy){
		$updateData['bid_strategy'] = $bid_strategy;
	}
	if($budgetType && $budgetAmount){
		$updateData[$budgetType] = $budgetAmount;
	}

	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post(
			"/$campaignId",
			$updateData
		);
	} catch (Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
//	echo "<pre><br>=============================<br>";
//	print_r($response);
//	echo "</pre>";

	$graphNode = $response->getGraphNode();
	return $graphNode;
}


//echo updateFBCampaign('23846914373490624', 'PAUSED' , "sMedia Dynamic Lead Lookalike-titanauto_Vehicle_ALL SEGMENTS_NEW");

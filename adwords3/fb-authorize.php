<?php

define('adlang', 'en');

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once __DIR__ . '/Google/Util.php';
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/Facebook/Fb.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use FacebookAds\Api;
use FacebookAds\Object\AdAccountUser;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Search\TargetingSearchTypes;

// Init PHP Sessions
session_start();

$fb = new Facebook([
	'app_id' => '1624969190861580',
	'app_secret' => 'ff8bee697d0d4dde38e7f15461700258',
]);

$helper = $fb->getRedirectLoginHelper();

if (!isset($_SESSION['facebook_access_token'])) {
	$_SESSION['facebook_access_token'] = null;
}

if (!$_SESSION['facebook_access_token']) {

	$helper = $fb->getRedirectLoginHelper();

	try {
		$_SESSION['facebook_access_token'] = (string) $helper->getAccessToken();
	} catch (FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch (FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
}

if ($_SESSION['facebook_access_token']) {
	echo "You are logged in!<br/>";

	$campaign_id    = '6083818455290';
	$adset_id       = '6083513856690';
	$adset_name     = "Test Ad Set";

	$targeting      = [
		"age_max" => 65,
		"age_min" => 18,
		"geo_locations" => [
			"regions" => [
				[
					"key" => 536,
					"name" => 'Saskatchewan',
					"country" => 'CA'
				]
			],
			"location_types" => ['home']
		],
		"publisher_platforms" => ['facebook'],
		"facebook_positions"    => ['feed'],
		"device_platforms" => ['desktop']
	];

	$car = [
		'stock_number'  => '170103BP',
		'year'          => '2013',
		'make'          => 'Ford',
		'model'         => 'Explorer',
		'price'         => '$27,980',
		'stock_type'    => 'used',
		'url'           => 'https://www.titanauto.ca/inventory/2013-ford-explorer-limited-parking-sensors-pst-paid-4x4-sport-utility-1fm5k8f8xdga67337'
	];

	$title = "{$car['year']} {$car['make']} {$car['model']} " . butifyPrice($car['price']);
	$description = "Test drive the {$car['year']} {$car['make']} {$car['model']} today";
	$banner_url = 'https://tm.smedia.ca/adwords3/banner.php?lang=en&config=custom1200&template=titanauto&style=facebookad&type=usedretargeting&stock_number=170103BP&year=2013&title=2013+Ford+Explorer&make=Ford&model=Explorer&trim=Limited&body_style=Sport+Utility&price=%2427%2C980&img1=http%3A%2F%2Fff3973422e3ac9862e05-8d908d1bf37c2ec86c6a15736e532783.r39.cf1.rackcdn.com%2F1FM5K8F8XDGA67337%2Ffefeb8d6f1e88c10756fca491c87b511.jpg&img2=http%3A%2F%2Fff3973422e3ac9862e05-8d908d1bf37c2ec86c6a15736e532783.r39.cf1.rackcdn.com%2F1FM5K8F8XDGA67337%2F4995d45772cda0d34453061b57c6558c.jpg&img3=http%3A%2F%2Fff3973422e3ac9862e05-8d908d1bf37c2ec86c6a15736e532783.r39.cf1.rackcdn.com%2F1FM5K8F8XDGA67337%2F1e1fb0d1ce66e808b75145db962e036f.jpg&img4=http%3A%2F%2Fff3973422e3ac9862e05-8d908d1bf37c2ec86c6a15736e532783.r39.cf1.rackcdn.com%2F1FM5K8F8XDGA67337%2Fe6990d09acb29a8d5bedb6daf10806b4.jpg&title_color=%2523ffffff&hst=false';

	$fb = new Fb(
		'1624969190861580', // App ID
		'ff8bee697d0d4dde38e7f15461700258',
		$_SESSION['facebook_access_token'],
		'1305844339453526' /* Account Id */,
		'288924967912308' /* Page Id */,
		'457794264564320' /* Pixel Id */,
		'303901506711149' /* dataset */,
		'1857779634543326' /* Form Id */,
		null
	);

	$result = TargetingSearch::search(
		TargetingSearchTypes::GEOLOCATION,
		null,
		'Oregon',
		array(
			'location_types' => array('region'),
		)
	);

	echo "<pre>";
	print_r($result);
	echo "<pre>";
	die();

	/*echo "<pre>";
    //print_r($fb->createCampaign("Test Polkdata Campaign", \FacebookAds\Object\Values\CampaignObjectiveValues::PRODUCT_CATALOG_SALES, ['product_catalog_id' => '721621931323039']));//$fb->getCampaignById('23842517358140439'));//$fb->getAdCreative('23842604474830439'));$fb->getAds('23842517358140439', '23842517358160439'));
    print_r($fb->getAdSets('23842677672000149'));//$fb->createMessengerAd($adset_id, $car, $title, $description, $banner_url, Fb::TARGETING_TYPE_RETARGETING));//$fb->enableRetargetting($adset_id, $car));
    echo "</pre>";
    echo "<pre>";
   //print_r($fb->getCampaigns());
    echo "</pre>";
    die();*/

	Api::init(
		'1624969190861580', // App ID
		'ff8bee697d0d4dde38e7f15461700258',
		$_SESSION['facebook_access_token'] // Your user access token
	);

	echo "Initialized Ads Api<br/>";
	$me = new AdAccountUser('me');
	echo "Me is initialized<br/>";
	//$my_adaccount = $me->getAdAccounts([AdAccountFields::ACCOUNT_ID, AdAccountFields::NAME], []);
	$account = new AdAccount('act_838782926159672');
	$maccount = $account->getSelf([AdAccountFields::ACCOUNT_ID, AdAccountFields::NAME]);
	echo "My acocunt is loaded<br/>";
	echo "<pre>";
	print_r($account->getCampaigns([CampaignFields::NAME, CampaignFields::EFFECTIVE_STATUS, CampaignFields::OBJECTIVE])->current()->getData());
	echo "</pre>";
	die();
	echo "Got my accounts<br/>";

	while ($my_adaccount->current()) {
		echo "<pre>";
		print_r($my_adaccount->current()->getData());
		echo "</pre>";
		$my_adaccount->next();
	}
} else {
	$permissions = ['ads_management'];
	$loginUrl = $helper->getLoginUrl('https://tm.smedia.ca/adwords3/fb-authorize.php', $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook</a>';
}

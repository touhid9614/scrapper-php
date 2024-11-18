<?php

$sys_debug  = filter_input(INPUT_GET, 'sys_debug') == '1';
$show_error = filter_input(INPUT_GET, 'show_error') == '1';

if ($show_error) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

use sMedia\Core\Registry;

// Override banners cache directory
Registry::set('cache_dir', dirname(__DIR__) . '/banner/');

if (!class_exists('Mutex')) {
	class Mutex
	{
		public static function create()
		{
			return time();
		}

		public static function destroy($mutex)
		{
			// Destroy
		}

		public static function lock($mutex)
		{
			// Lock
		}

		public static function trylock($mutex)
		{
			// Try Lock
		}

		public static function unlock($mutex)
		{
			// Unlock
		}
	}
}

require_once __DIR__ . '/db-config.php';
require_once __DIR__ . '/smedia-vendor-regex.php';

$tmp_path       = dirname(__FILE__) . '/';
$abs_path       = str_replace('\\', '/', $tmp_path);
$dashboard_path = dirname($abs_path) . '/dashboard/';

if (!defined('CACHEDIR')) {
	define('CACHEDIR', $dashboard_path . 'cache/');
}

define('yes', true);
define('no', false);

global $set_path, $google_config, $google_config_new, $developer_token, $db_config,
	$CronConfigs, $scrapper_configs, $market_buyers, $proxy_list, $carlistdb_path, $carlist,
	$adcarlist_path, $advanced_carlist, $fuel_type_carlist, $number_of_retries, $custom_dealerships,
	$max_crons, $fb_access_token, $single_config, $marketcheck_api_url, $marketcheck_api_key,
	$nlp_api, $smedia_crawler_db, $smedia_website_providers, $smedia_carchat_providers, $smedia_trade_providers, $smedia_other_providers, $area_proxy;

$number_of_retries = 10;
$max_crons         = 400;

// application data file. Don't change.
$set_path       = __DIR__ . '/data/config.dat';
$fb_token_path  = __DIR__ . '/data/fb-token.dat';
$proxy_list     = __DIR__ . '/data/proxy-list.txt';
$carlistdb_path = __DIR__ . '/data/carlistdb.csv';
$adcarlist_path = __DIR__ . '/data/advanced_car_data.csv';

$area_proxy = [
	'CA' => __DIR__ . '/data/ca-proxy-list.txt',
	'FL' => __DIR__ . '/data/fl-proxy-list.txt',
];

if (file_exists($fb_token_path)) {
	$fb_access_token = file_get_contents($fb_token_path);
} else {
	$fb_access_token = '';
}

$carlist          = [];
$advanced_carlist = [];

// google adwords configuration
$google_config = [
	"client_id"     => "245770412491-38epoe86jcal01fct4p8parm9s0n8gvu.apps.googleusercontent.com",
	"client_secret" => "YLJMWXIbxP51WP2XhiA4nQG-",
	"scope"         => "https://www.googleapis.com/auth/adwords https://www.googleapis.com/auth/analytics https://www.googleapis.com/auth/analytics.edit https://www.googleapis.com/auth/analytics.readonly",
	"redirect_uri"  => "https://tools.smedia.ca/adwords3/authorize.php",
];

$google_config2 = [
	"client_id"     => "245770412491-38epoe86jcal01fct4p8parm9s0n8gvu.apps.googleusercontent.com",
	"client_secret" => "YLJMWXIbxP51WP2XhiA4nQG-",
	"scope"         => "https://www.googleapis.com/auth/adwords https://www.googleapis.com/auth/analytics https://www.googleapis.com/auth/analytics.edit https://www.googleapis.com/auth/analytics.readonly",
	"redirect_uri"  => "https://tools.smedia.ca/adwords3/authorize.php",
];

$google_config_old = array(
	"client_id"     => "546227024726-1g2erd75jck66j6uegvdfm87pgk72gfa.apps.googleusercontent.com",
	"client_secret" => "7znt6VuM6cEWQ6vhdFAsEWot",
	"scope"         => "https://www.googleapis.com/auth/adwords https://www.googleapis.com/auth/analytics https://www.googleapis.com/auth/analytics.edit https://www.googleapis.com/auth/analytics.readonly",
	"redirect_uri"  => "https://tools.smedia.ca/adwords3/authorize.php",
);

$google_config_old2 = array(
	"client_id"     => "546227024726-1g2erd75jck66j6uegvdfm87pgk72gfa.apps.googleusercontent.com",
	"client_secret" => "7znt6VuM6cEWQ6vhdFAsEWot",
	"scope"         => "https://www.googleapis.com/auth/adwords https://www.googleapis.com/auth/analytics https://www.googleapis.com/auth/analytics.edit https://www.googleapis.com/auth/analytics.readonly",
	"redirect_uri"  => "https://tools.smedia.ca/adwords3/authorize.php",
);

$google_config_reporting = [
	"client_id"     => "193861955908-ec71sb946kcmemt3du4vkt8c18mfo80j.apps.googleusercontent.com",
	"client_secret" => "eDMzVAfl-slnK7DDxZx9vJdF",
	"scope"         => "https://www.googleapis.com/auth/adwords https://www.googleapis.com/auth/analytics https://www.googleapis.com/auth/analytics.edit https://www.googleapis.com/auth/analytics.readonly",
	"redirect_uri"  => "https://tools.smedia.ca/adwords3/authorize.php",
];

$reachDynamicsCredentials = [
	'marshal' => [
		'url'   => 'https://client.reachdynamics.com/',
		'email' => 'marshal@smedia.ca',
		'pass'  => 'aUx891',
	],
	'tracy'   => [
		'url'   => 'https://client.reachdynamics.com/',
		'email' => 'tracy@smedia.ca',
		'pass'  => '7bj&nn',
	],
];

$google_config_new['marshal']       = $google_config;
$google_config_new['analytics.h-o'] = $google_config;
$google_config_new['reporting']     = $google_config;
$google_config_new['reporting-new'] = $google_config_reporting;
$google_config_new['marshal-old']   = $google_config_old;

$google_account = isset($_GET['customer']) ? $_GET['customer'] : 'marshal';

if ($sys_debug) {
	echo "Google Config<br>";
	print_r($google_account);
	echo "<br>-------------<br>";
	print_r($google_config_new);
	echo "<br>-------------<br>";
	print_r($google_config_new[$google_account]);
	echo "<br>-------------<br>";
}

$fb_config = [
	'app_id'     => '1624969190861580',
	'app_secret' => 'ff8bee697d0d4dde38e7f15461700258',
];

// Google Maps API config
// $maps_api_key      = 'AIzaSyBNuJIIfCBJWnlJodJa8vDPkk_2VS34NUc';  // shuhan@smedia.ca
$maps_api_key      = 'AIzaSyB5Ohlf5iJRHWwiqccyaPJQfLscCNmz_Tc'; // abbas@smedia.ca
$maps_api_endpoint = 'https://maps.google.com/maps/api/geocode/json?sensor=false';

$ses_config = [
	'version' => '2010-12-01',
	'region'  => 'us-east-1',
	'key'     => 'AKIAJK2PQ2QGV5X6XHHA',
	'pass'    => 'Ah+d+/iH4Y/AmmtlLgumhzNunhAQn5EnfXFokLLYJo4D',
];

$marketcheck_api_key = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$marketcheck_api_url = "https://marketcheck-prod.apigee.net/v1/search?api_key={$marketcheck_api_key}";

$nlp_api           = "https://crawler-api.smedia.ca/api/";
$smedia_crawler_db = "mongodb://crawler:zLPMRijB8iNAgrhb9z@mongo.smedia.ca:27017/smediacrawler?authSource=smediacrawler&readPreference=primary&appname=smedia&ssl=false";

// adwords developer token
$developer_token = "tB7q9XIC-hhT_zgNwQ_6wg";
$debug           = filter_input(INPUT_GET, 'debug') == 'true';

$configs_file             = __DIR__ . "/caches/configs.php";
$custom_config_directory  = __DIR__ . "/custom_dealerships";
$custom_filters_directory = __DIR__ . "/custom_filters";

// Directory to load marketbuyers configurations from
$market_buyers_directory = __DIR__ . "/market-buyers";

if (isset($single_config) && $single_config instanceof Closure) {
	$single_config = $single_config();
}

if (isset($single_config) && !empty($single_config)) {

	// single_config name can be change now. we can load multiple specified configs now
	$configs_to_load = is_array($single_config) ? $single_config : [$single_config];

	foreach ($configs_to_load as $current_config_to_load) {

		if ((isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'smedia-inventory.test')) || (getenv('PHP_LOCAL') == '1')) {
			$config_file          = "{$abs_path}config/{$current_config_to_load}.php";
			$scrapper_config_file = "{$abs_path}scrapper-config/{$current_config_to_load}.php";

			if (file_exists($config_file)) {
				$config_content = file_get_contents($config_file);
			}

			if (file_exists($scrapper_config_file)) {
				$scrapper_config_content = file_get_contents($scrapper_config_file);
			}
		} else {
			include_once $dashboard_path . 's3-update.php';
			$config_content          = s3DealerConfig($current_config_to_load);
			$scrapper_config_content = s3DealerConfig($current_config_to_load, true);
		}

		if (isset($config_content)) {
			$config_content = trim(str_replace('<?php', '', $config_content));

			if (substr($config_content, -2) == '?>') {
				$config_content = trim(substr($config_content, 0, strlen($config_content) - 2));
			}

			eval($config_content);
		}

		if (isset($scrapper_config_content)) {
			$scrapper_config_content = trim(str_replace('<?php', '', $scrapper_config_content));

			if (substr($scrapper_config_content, -2) == '?>') {
				$scrapper_config_content = trim(substr($scrapper_config_content, 0, strlen($scrapper_config_content) - 2));
			}

			eval($scrapper_config_content);
		}

		if (!isset($config_content) && file_exists($configs_file)) {
			if ($sys_debug) {
				echo "Configs - {$configs_file}<br>";
			}

			require_once $configs_file;
		} else {
			if ($sys_debug) {
				echo "Configs file missing - {$configs_file}<br>";
			}
		}
	}
} else {
	if (!isset($config_content) && file_exists($configs_file)) {
		if ($sys_debug) {
			echo "Configs - {$configs_file}<br>";
		}

		require_once $configs_file;
	} else {
		if ($sys_debug) {
			echo "Configs file missing - {$configs_file}<br>";
		}
	}
}


$custom_dealerships = [];

if (is_dir($custom_config_directory)) {
	foreach (array_filter(glob($custom_config_directory . '/*.php'), 'is_file') as $file) {
		if ($sys_debug) {
			echo "Custom - {$file}<br>";
		}

		require_once $file;
	}
}

if (is_dir($custom_filters_directory)) {
	foreach (array_filter(glob($custom_filters_directory . '/*.php'), 'is_file') as $file) {
		if ($sys_debug) {
			echo "Custom Filter - {$file}<br>";
		}

		require_once $file;
	}
}

$market_buyers = [];

if (is_dir($market_buyers_directory)) {
	foreach (array_filter(glob($market_buyers_directory . '/*.php'), 'is_file') as $file) {
		if ($sys_debug) {
			echo "Market buyers - {$file}<br>";
		}

		require_once $file;
	}
}

date_default_timezone_set("America/Regina");

if ($sys_debug) {
	echo "Default timezone is America/Regina<br>";
}

foreach ($CronConfigs as $loc_cron_name => $loc_cron_config) {
	// NOT IN USE
	$budget = null; // $loc_db_connect->get_meta('budget', $loc_cron_name);

	if ($budget) {
		if (isset($budget['max_cost'])) {
			$loc_cron_config['max_cost'] = $budget['max_cost'];
		}

		if (isset($budget['cost_distribution'])) {
			$loc_cron_config['cost_distribution'] = $budget['cost_distribution'];
		}

		$CronConfigs[$loc_cron_name] = $loc_cron_config;

		if (!isset($CronConfigs[$loc_cron_name]['password'])) {
			$CronConfigs[$loc_cron_name]['password'] = $loc_cron_name;
		}
	}
	/*      END NOT IN USE      */

	/*      SUPPORT FOR PRORATE BUDGETS     */
	$start_date = isset($loc_cron_config['start_date']) ? strtotime($loc_cron_config['start_date']) : null;

	if ($start_date && date('n', $start_date) == date('n') && date('Y', $start_date) == date('Y')) {
		$days_in_month = date('t');
		$days          = ($days_in_month - date('j', $start_date)) + 1;

		$CronConfigs[$loc_cron_name]['max_cost'] = isset($loc_cron_config['prorated_budget']) ? $loc_cron_config['prorated_budget'] : ($loc_cron_config['max_cost'] / $days_in_month) * $days;
	}

	$CronConfigs[$loc_cron_name]['on15'] = false; //To disable on15 seperation completely

	if (!isset($CronConfigs[$loc_cron_name]['campaigns'])) {
		$CronConfigs[$loc_cron_name]['campaigns'] = [];
	}

	$google_campaign_list = [
		"special_search"         => $loc_cron_name . "_special_search",
		"new_search"             => $loc_cron_name . "_new_search",
		"used_search"            => $loc_cron_name . "_used_search",
		"new_placement"          => $loc_cron_name . "_new_placement",
		"used_placement"         => $loc_cron_name . "_used_placement",
		"new_display"            => $loc_cron_name . "_new_image",
		"used_display"           => $loc_cron_name . "_used_image",
		"new_retargeting"        => $loc_cron_name . "_new_remarketing",
		"used_retargeting"       => $loc_cron_name . "_used_remarketing",
		"new_marketbuyers"       => $loc_cron_name . "_new_marketbuyers",
		"used_marketbuyers"      => $loc_cron_name . "_used_marketbuyers",
		"new_combined"           => $loc_cron_name . "_new_combined",
		"used_combined"          => $loc_cron_name . "_used_combined",
		"new_color"              => $loc_cron_name . "_new_color",
		"used_color"             => $loc_cron_name . "_used_color",
		"device_search"          => $loc_cron_name . "_device_search",
		"accessory_search"       => $loc_cron_name . "_accessory_search",
		"device_display"         => $loc_cron_name . "_device_display",
		"accessory_display"      => $loc_cron_name . "_accessory_display",
		"device_retargeting"     => $loc_cron_name . "_device_retargeting",
		"accessory_retargeting"  => $loc_cron_name . "_accessory_retargeting",
		"device_marketbuyers"    => $loc_cron_name . "_device_marketbuyers",
		"accessory_marketbuyers" => $loc_cron_name . "_accessory_marketbuyers",
		"device_combined"        => $loc_cron_name . "_device_combined",
		"accessory_combined"     => $loc_cron_name . "_accessory_combined",
	];

	$CronConfigs[$loc_cron_name]['campaigns'] = array_merge($google_campaign_list, $CronConfigs[$loc_cron_name]['campaigns']);

	if (isset($CronConfigs[$loc_cron_name]['create']['new_combined']) && $CronConfigs[$loc_cron_name]['create']['new_combined']) {
		$CronConfigs[$loc_cron_name]['create']['new_placement'] = yes;
	}

	if (isset($CronConfigs[$loc_cron_name]['create']['used_combined']) && $CronConfigs[$loc_cron_name]['create']['used_combined']) {
		$CronConfigs[$loc_cron_name]['create']['used_placement'] = yes;
	}

	if (isset($scrapper_configs[$loc_cron_name]['proxy-area'])) {
		$CronConfigs[$loc_cron_name]['proxy-area'] = $scrapper_configs[$loc_cron_name]['proxy-area'];
	}
}

foreach ($custom_dealerships as $loc_cron_name => $loc_cron_config) {
	/*      NOT IN USE      */
	$budget = null; // $loc_db_connect->get_meta('budget', $loc_cron_name);

	if ($budget) {
		if (isset($budget['max_cost'])) {
			$loc_cron_config['max_cost'] = $budget['max_cost'];
		}

		if (isset($budget['cost_distribution'])) {
			$loc_cron_config['cost_distribution'] = $budget['cost_distribution'];
		}

		$custom_dealerships[$loc_cron_name] = $loc_cron_config;
	}
	/*      END NOT IN USE      */

	// TODO: quick hack fix remove after 29th february
	if (time() > strtotime("1 March 2016") && isset($custom_dealerships[$loc_cron_name]['on15'])) {
		unset($custom_dealerships[$loc_cron_name]['on15']);
	}

	/*      SUPPORT FOR PRORATE BUDGETS     */
	$start_date = isset($loc_cron_config['start_date']) ? strtotime($loc_cron_config['start_date']) : null;

	if ($start_date && date('n', $start_date) == date('n') && date('Y', $start_date) == date('Y')) {
		$days_in_month = date('t');
		$days          = ($days_in_month - date('j', $start_date)) + 1;

		$custom_dealerships[$loc_cron_name]['max_cost'] = isset($loc_cron_config['prorated_budget']) ? $loc_cron_config['prorated_budget'] : ($loc_cron_config['max_cost'] / $days_in_month) * $days;
	}
}

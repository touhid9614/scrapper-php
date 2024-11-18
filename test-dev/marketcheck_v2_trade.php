<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir       = dirname(__DIR__);
$adwords_dir    = "{$base_dir}/adwords3";
$log_path   	= "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2.log";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $proxy_list;

$trade_providers = [
	'TradeVue'			=> '/.*tradevue.*/',
	'TradeGauge'		=> '/.*drivecarma\.ca\/.*/',
	'Edmunds'			=> '/.*edmunds-media\.com\/.*/',
	'Edmunds'			=> '/.*edmunds\.com\/.*/',			// Owned by kelly blue book
	'Edmunds'			=> '/.*edmunds.*/',					// Owned by kelly blue book
	'Tradesii'			=> '/.*tradesii\.com\/.*/',
	'Accutrade'			=> '/.*accu\-trade\.com\/.*/',
	'TradeRev'			=> '/.*traderev\.com\/.*/',
	'TradePending'		=> '/.*tradepending.*/',			// Owned by kelly blue book
	'KellyBlueBook'		=> '/.*kbb\.com\/.*/',
	'KellyBlueBook'		=> '/.*KBB Instant Cash Offer.*/',
	'TrueCarTrade'		=> '/.*truecar.*/',
	'CarNow'			=> '/.*carnow\.com\/.*/',
	'CarNow'			=> '/.*carnowdealerkey.*/',
	'DealerGears'		=> '/.*dealergears\.com\/.*/',
	'AutoNation'		=> '/.*autonation\.com\/.*/',
	'Vauto'				=> '/.*vauto\.com\/.*/',
	'Autolist'			=> '/.*autolist\.com\/.*/',
	'Instamotor'		=> '/.*instamotor\.com\/.*/',
	'CarMax'			=> '/.*carmax\.com\/.*/',
	'Cars'				=> '/.*\.cars\.com\/.*/',
	'Dealertrackcanada'	=> '/.*dealertrackcanada\.com\/.*/',
	'Autotrader'		=> '/.*autotrader\.ca.*/',
	'Guaranteedtrade'	=> '/.*guaranteedtrade\.com.*/',
	'Xchangevalue'		=> '/.*xchangevalue\.com.*/',
	'Tradeinvalet'		=> '/.*tradeinvalet\.com.*/',
	'YogaCars'			=> '/.*yogaCarsConfig.*/',
	'BlackBook'			=> '/.*blackbook.*/',
	'Roadster'			=> '/.*roadster\.com.*/',
	'Purecars'			=> '/.*purecars\.com.*/',
	'MaxAllowance'		=> '/.*maxallowance\.com.*/',
	'Carfax'			=> '/.*carfax\-trade\-in\-token.*/',	// Owned by autotrader
	'Autoverify'		=> '/.*autoverify\.com\/.*/'
];

$marketcheck_table = "marketcheck_dealers_v2";

$start_id 	= isset($_GET['start_id']) ? intval(filter_input(INPUT_GET, 'start_id')) : false;
$limit 		= isset($_GET['limit']) ? intval(filter_input(INPUT_GET, 'limit')) : false;

if (isset($argv)) {
	$arguments 	= $argv[1];
	$output 	= explode(":", $arguments, 3);
	$start_id 	= intval($output[0]);
	$limit 		= intval($output[1]);
	$instance 	= intval($output[2]);
	$log_path   = "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2_{$instance}.log";
	writeLog($log_path, "Received {$start_id}, {$limit} & {$instance} as arguments for trade.");
}

$db_connect = new DbConnect('');
$key 		= '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$existing 	= [];
$query 		= "SELECT dealer_id, inventory_url FROM $marketcheck_table WHERE (trade IS NULL);";

if ($start_id) {
	$query 	= "SELECT dealer_id, inventory_url FROM $marketcheck_table WHERE (trade IS NULL AND dealer_id >= $start_id);";
}

if ($start_id && $limit) {
	$query 	= "SELECT dealer_id, inventory_url FROM $marketcheck_table WHERE (trade IS NULL AND dealer_id >= $start_id) LIMIT $limit;";
}

$result = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($result)) {
	$existing[$row['dealer_id']] = $row['inventory_url'];
}

foreach ($existing as $id => $inventory_url) {
	$url 	= "https://marketcheck-prod.apigee.net/v2/search/car/recents?api_key=$key&dealer_id=$id&rows=1";
	$data 	= HttpGet($url, $proxy_list);
	$data 	= json_decode($data, true);
	$vdp 	= (isset($data['listings']) && isset($data['listings'][0])) ? $data['listings'][0]['vdp_url'] : null;

	// We can get trade and provider in vdp page
	if ($vdp && !empty($vdp)) {
		$vdp_response 	= HttpGet($vdp, $proxy_list);
		$trade_query 	= get_trade_provider_query($vdp_response, $trade_providers, $inventory_url, $proxy_list);

		$encoded_vdp = urlencode($vdp);

		$query = "UPDATE $marketcheck_table SET vdp='$encoded_vdp', $trade_query WHERE dealer_id=$id;";
		$db_connect->query($query);
		writeLog($log_path, $query);
	} else {
		$root_reponse 	= HttpGet($inventory_url, $proxy_list);
		$trade_query 	= get_trade_provider_query($root_reponse, $trade_providers, $inventory_url, $proxy_list);

		$query = "UPDATE $marketcheck_table SET $trade_query WHERE dealer_id=$id;";
		$db_connect->query($query);
		writeLog($log_path, $query);
	}
}

$db_connect->close_connection();


/**
 * Gets the trade provider query.
 *
 * @param      <type>  $response       The response
 * @param      <type>  $providers      The providers
 * @param      <type>  $inventory_url  The inventory url
 * @param      <type>  $proxy_list     The proxy list
 *
 * @return     string  The trade provider query.
 */
function get_trade_provider_query($response, $providers, $inventory_url, $proxy_list)
{
	$trade = '';
	$trade_url_log = dirname(__DIR__) . "/adwords3/caches/marketcheck-test/trade_urls.log";

	foreach ($providers as $provider => $regex) {
		if (preg_match($regex, $response)) {
			$trade .= $provider . ' ';
		}
	}

	if (empty($trade)) {
		// try forcibly from most common url
		$url_parts = parse_url($inventory_url);
		$host = $url_parts['host'];
		$scheme = $url_parts['scheme'];
		$trade_url = "{$scheme}://{$host}/value-your-trade/";
		$trade_response = HttpGet($trade_url, $proxy_list);

		if ($trade_response) {
			foreach ($providers as $provider => $regex) {
				if (preg_match($regex, $trade_response)) {
					$trade .= $provider . ' ';
				}
			}
		}

		if (empty($trade)) {
			// Search for trade tool url in sitemap
			$sitemap_url = "{$scheme}://{$host}/sitemap.xml";

			$resp = HttpGet($sitemap_url, $proxy_list);

			if (!$resp) {
				$sitemap_url = "{$scheme}://{$host}/sitemap_index.xml";
			}

			$trade_regex = '/(trade|sell|offer|instant|value)/i';	// sell, offer, trade,
			$url_types = classifyURLs(getSitemap(trim($sitemap_url)), ['trade' => $trade_regex]);
			$webform = false;

			foreach ($url_types as $currentUrl => $page_type) {
				if ($page_type == 'trade') {
					$current_response = HttpGet($currentUrl, $proxy_list);

					foreach ($providers as $provider => $regex) {
						if (preg_match($regex, $current_response)) {
							$trade .= $provider . ' ';
						}
					}

					$webform = true;
					writelog($trade_url_log, $currentUrl);
				}
			}

			if (empty($trade)) {
				// Another forced trial
				$trade = "N/A";

				if ($webform) {
					$trade = "web_form_or_loading";
				}
			}
		}
	}

	return " trade = '$trade' ";
}

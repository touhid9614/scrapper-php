<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";


$db_api = 'http://127.0.0.1:3000/v1/data-backfill/get-all-active-dealers';
$cookie = '';
$content_type = 'application/json';
$additional_headers = [
    'masterToken' => '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b'
];
$dbreq = json_decode(HttpGet($db_api, false, false, $cookie, $cookie, $content_type, $additional_headers), true);


$output = [];


$dest      = __DIR__ . '/gsheet_vs_db.csv';
$outstream = fopen($dest, 'w+');
fputcsv($outstream, ['dealership', 'guid', 'dealerid', 'issue, db, sheet', 'issue, db, sheet', 'issue, db, sheet', 'issue, db, sheet', 'issue, db, sheet', 'issue, db, sheet', 'issue, db, sheet', 'issue, db, sheet', 'issue, db, sheet']);

foreach ($dbreq['dealers'] as $idx => $dealer) {
	$guid = $dealer['guid'];
	$gsheet_guid_api = "https://omni-channel.api.smedia.ca/fetch-account-by-guid/{$guid}/";
	$gdata = json_decode(HttpGet($gsheet_guid_api), true);
	$gdata = $gdata[0];

	if ($gdata['Active'] == 'FALSE') {
		continue;
	}

	$temp = [];

	if (replace_dash($dealer['adwordsId']) != replace_dash($gdata['Google Ads Account ID'])) {
		$temp[] = "Google Adwords, '" . $dealer['adwordsId'] . "', '" . $gdata['Google Ads Account ID'] . "'";
	}

	if (replace_email($dealer['account']) != replace_email($gdata['GoogleAnalyticsEmail'])) {
		$temp[] = "Analytics Email, '" . $dealer['account'] . "', '" . $gdata['GoogleAnalyticsEmail'] . "'";
	}

	if ($dealer['viewId'] != $gdata['Google Analytics View ID']) {
		$temp[] = "Analytics View ID, '" . $dealer['viewId'] . "', '" . $gdata['Google Analytics View ID'] . "'";
	}

	if ($dealer['epConvGoal'] != $gdata['Engaged Prospect : Google Analytics Conversion Goal']) {
		$temp[] = "EPM Goal No, '" . $dealer['epConvGoal'] . "', '" . $gdata['Engaged Prospect : Google Analytics Conversion Goal'] . "'";
	}

	if ($dealer['smViewGoal'] != $gdata['Smart Offer View Goal']) {
		$temp[] = "Smart Offer View, '" . $dealer['smViewGoal'] . "', '" . $gdata['Smart Offer View Goal'] . "'";
	}

	if ($dealer['smLeadGoal'] != $gdata['Smart Offer Lead Goal']) {
		$temp[] = "Smart Offer Lead, '" . $dealer['smLeadGoal'] . "', '" . $gdata['Smart Offer Lead Goal'] . "'";
	}

	if ($dealer['fbAdAccountId'] != $gdata['Facebook Account ID']) {
		$temp[] = "FB ad account, '" . $dealer['fbAdAccountId'] . "', '" . $gdata['Facebook Account ID'] . "'";
	}

	if ($dealer['accountId'] != $gdata['Google Analytics UA-ID']) {
		$temp[] = "Analytics Account ID, '" . $dealer['accountId'] . "', '" . $gdata['Google Analytics UA-ID'] . "'";
	}

	if ($dealer['bingId'] != $gdata['Bing Account ID']) {
		$temp[] = "Bing ID, '" . $dealer['bingId'] . "', '" . $gdata['Bing Account ID'] . "'";
	}

	$tempLen = count($temp);
	if ($tempLen > 0) {
		$addMore = 9 - $tempLen;
		array_unshift($temp, $dealer['dealerName'], $guid, $dealer['dealershipId']);
		for ($i =0; $i < $tempLen; $i++) {
			$temp[] = '';
		}
		$output[] = $temp;

		fputcsv($outstream, $temp);
	}
}

print_r($output);

function replace_dash($str) {
	return str_replace("-", "", $str);
}

function replace_email($em) {
	return trim(strtolower(str_replace("@gmail.com", "", $str)));
}
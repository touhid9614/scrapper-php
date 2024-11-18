<?php

$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";
$log_path    = "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2.log";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $smedia_website_providers, $smedia_trade_providers, $smedia_carchat_providers, $smedia_other_providers;

$db_connect = new DbConnect('');

function pull_all_car_data($db_connect)
{
	$fetch      = $db_connect->query("SELECT dealership, websites FROM dealerships WHERE status = 'active' AND website_provider = '' ORDER BY dealership ASC;");

	$dealerships = [];
	while ($row = mysqli_fetch_assoc($fetch)) {
		array_push($dealerships, $row['dealership']);
	}

	$car_svins = [];

	foreach ($dealerships as $dealer) {
		$fetch      = $db_connect->query("SELECT svin, url, stock_type, biweekly, lease, lease_term, lease_rate, finance, finance_term, finance_rate, currency, doors, passenger, auto_texts,  no_feed, custom, engaged, price_history, msrp, price, vin, exterior_color, interior_color FROM {$dealer}_scrapped_data where deleted=0");
		while ($row = mysqli_fetch_assoc($fetch)) {
			array_push($car_svins, (object)[
				"dealership" => $dealer,
				"svin" => $row['svin'],
				"vin" => $row['vin'],
				"stock_type" => $row['stock_type'],
				"biweekly" => $row['biweekly'],
				"lease" => $row['lease'],
				"lease_term" => $row['lease_term'],
				"lease_rate" => $row['lease_rate'],
				"finance" => $row['finance'],
				"finance_term" => $row['finance_term'],
				"finance_rate" => $row['finance_rate'],
				"currency" => $row['currency'],
				"doors" => $row['doors'],
				"passenger" => $row['passenger'],
				"auto_texts" => $row['auto_texts'],
				"no_feed" => $row['no_feed'],
				"custom" => $row['custom'],
				"engaged" => $row['engaged'],
				"options" => $row['options'],
				"warranty" => $row['warranty'],
				"make" => $row['make'],
				"model" => $row['model'],
				"year" => $row['year'],
				"trim" => $row['trim'],
				"price" => $row['price'],
				"msrp" => $row['msrp'],
				"exterior_color" => $row['exterior_color'],
				"interior_color" => $row['interior_color'],
				"price_history" => unserialize($row['price_history']),
				"short_svin" =>  substr($row['svin'], -6, 6),
				"url" => $row['url'],
			]);
		}
	}
	file_put_contents("all_car_data.json", json_encode($car_svins));
}

function dup_svin_checker($data)
{
	$svins = array_map(function ($v) {
		return $v->svin;
	}, $data);

	$couts = array_count_values($svins);

	$dups = [];

	foreach ($couts as $k => $c) {
		if ($c > 1) {
			$info = array_values(array_filter($data, function ($v) use ($k) {
				return $v->svin == $k;
			}));
			array_push($dups, $info);
			file_put_contents("./dups/$k", json_encode($info));
		}
	}

	return $dups;
}

function dealership_with(
	$data,
	$field,
	$car = false,
	$predicate = null
) {
	$predicate = $predicate != null
		? $predicate
		:
		function ($v) use ($field) {
			return $v->$field;
		};

	$custom = array_filter($data, $predicate);

	$custom_dealer = array_count_values(array_map(function ($v) {
		return $v->dealership;
	}, $custom));

	$res['dealers'] = $custom_dealer;

	if ($car == true) {
		$res['cars'] = $custom;
	}

	return $res;
}


// pull_all_car_data($db_connect);
$data =  json_decode(file_get_contents("all_car_data.json"));
// $dups = dup_svin_checker($data);
// file_put_contents('car-test/dupsvins.json', json_encode($dups));

var_dump(array_map(
	function ($c) {
		// return [$c->price, $c->price, (array)$c->price_history];
		return $c->msrp;
	},
	dealership_with($data, null, true, function ($car) {

		$invalid_price = array_filter((array)$car->price_history, function ($v) {
			return gettype($v) != "integer";
		});

		return count($invalid_price) > 0;
	})['cars']
));

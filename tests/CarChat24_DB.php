<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$base_dir          = dirname(__DIR__) . "/";
$adwords_dir       = $base_dir . "adwords3/";
$marketcheck_trade = $base_dir . 'reports/marketcheck_trade_in.csv';

$carChat24CSV = $base_dir . 'reports/CarChat24.csv';
$livechatCSV  = $base_dir . 'reports/livechat.csv';
$gubagooCSV   = $base_dir . 'reports/gubagoo.csv';
$foxdealerCSV = $base_dir . 'reports/foxdealer.csv';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$db_connect = new DbConnect('');

$URL = isset($_POST['url']) ? urldecode(filter_input(INPUT_POST, 'url')) : null;
//$DEALERSHIP = getDomainDealer(GetDomain($URL), $URL);

/*
$gubagoo    = isset($_POST['gubagoo']) ? urldecode(filter_input(INPUT_POST, 'gubagoo')) : null;
$foxdealer  = isset($_POST['foxdealer']) ? urldecode(filter_input(INPUT_POST, 'foxdealer')) : null;
$carchat24  = isset($_POST['carchat24']) ? urldecode(filter_input(INPUT_POST, 'carchat24')) : null;
$livechat   = isset($_POST['livechat']) ? urldecode(filter_input(INPUT_POST, 'livechat')) : null;
 */
$dealer_data = [];
// $dealer_data['website'] = $URL;

/*$dealer_data =
[
'website' => $URL,
'tradevue' => $TradeVue,
'tradegauge' => $TradeGauge,
'edmunds' => $Edmunds,
'tradesii' => $Tradesii,
'accutrade' => $Accutrade,
'traderev' => $TradeRev,
'tradepending' => $TradePending,
'kellybluebook' => $KellyBlueBook,
'truecartrade' => $TrueCarTrade
];*/

if (isset($_POST['TradeVue'])) {
    $dealer_data['tradevue'] = 'YES';
}

if (isset($_POST['TradeGauge'])) {
    $dealer_data['tradegauge'] = 'YES';
}

if (isset($_POST['Edmunds'])) {
    $dealer_data['edmunds'] = 'YES';
}

if (isset($_POST['Tradesii'])) {
    $dealer_data['tradesii'] = 'YES';
}

if (isset($_POST['Accutrade'])) {
    $dealer_data['accutrade'] = 'YES';
}

if (isset($_POST['traderev'])) {
    $dealer_data['traderev'] = 'YES';
}

if (isset($_POST['TradePending'])) {
    $dealer_data['tradepending'] = 'YES';
}

if (isset($_POST['KellyBlueBook'])) {
    $dealer_data['kellybluebook'] = 'YES';
}

if (isset($_POST['TrueCarTrade'])) {
    $dealer_data['truecartrade'] = 'YES';
}

//Trade In
/*$TradeVue       = isset($_POST['TradeVue']) ? 'YES' : '';
$TradeGauge     = isset($_POST['TradeGauge']) ? 'YES' : '';
$Edmunds        = isset($_POST['Edmunds']) ? 'YES' : '';
$Tradesii       = isset($_POST['Tradesii']) ? 'YES' : '';
$Accutrade      = isset($_POST['Accutrade']) ? 'YES' : '';
$traderev       = isset($_POST['traderev']) ? 'YES' : '';
$TradePending   = isset($_POST['TradePending']) ? 'YES' : '';
$KellyBlueBook  = isset($_POST['KellyBlueBook']) ? 'YES' : '';
$TrueCarTrade   = isset($_POST['TrueCarTrade']) ? 'YES' : '';*/

/*if ($gubagoo == true)
{
fputcsv($outstream, [$DEALERSHIP, $URL, 'Gubagoo is active.']);
fclose($outstream);
}

if ($carchat24 == true)
{
fputcsv($outstream, [$DEALERSHIP, $URL, 'CarChat24 is active.']);
fclose($outstream);
}

if ($livechat == true)
{
fputcsv($outstream, [$DEALERSHIP, $URL, 'Live Chat is active.']);
fclose($outstream);
}

if ($foxdealer == true)
{
fputcsv($outstream, [$DEALERSHIP, $URL, 'Foxdealer is active.']);
fclose($outstream);
}*/

/*$outstream  = fopen($marketcheck_trade, 'a+');
fputcsv($outstream, [$URL, $TradeVue, $TradeGauge, $Edmunds, $Tradesii, $Accutrade, $TradeRev, $TradePending, $KellyBlueBook, $TrueCarTrade]);
fclose($outstream);*/

$prepared_data = $db_connect->prepare_query_params($dealer_data, DbConnect::PREPARE_EQUAL);
$query         = "UPDATE s_trade_competetor SET $prepared_data WHERE website = '$URL';";
$db_connect->query($query);

echo json_encode(["query" => $query]);

//writeLog($base_dir . 'reports/CarChat24_DB.log', $query);

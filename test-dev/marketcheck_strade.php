<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = $base_dir . "/adwords3/";
// $data_dir       = $adwords_dir . '/data/marketcheck/';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$marketchek_table = "marketcheck_dealers_v2";

global $proxy_list;

// Trade In
$tv = '/.*tradevue.*/';                  // TradeVue
$tg = '/.*drivecarma\.ca\/.*/';          // TradeGauge
$ed = '/.*edmunds-media\.com\/.*/';      // Edmunds
$es = '/.*edmunds\.com\/.*/';            // Edmunds
$ti = '/.*tradesii\.com\/.*/';           // Tradesii
$at = '/.*accu\-trade\.com\/.*/';        // Accutrade
$tr = '/.*traderev\.com\/.*/';           // TradeRev
$tp = '/.*tradepending\.com\/.*/';       // TradePending
$kb = '/.*kbb\.com\/.*/';                // KellyBlueBook
$tc = '/.*truecar\.*/';                  // TrueCarTrade

$start_id = isset($_GET['start_id']) ? filter_input(INPUT_GET, 'start_id') : false;
$limit    = isset($_GET['limit']) ? intval(filter_input(INPUT_GET, 'limit')) : false;

$db_connect = new DbConnect('');
$key        = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$existing   = [];
$query      = "SELECT dealer_id, vdp FROM $marketchek_table WHERE (total_owned > 0 AND vdp != '' AND vdp IS NOT NULL AND trade IS NULL);";

if ($start_id && $limit) {
    $query = "SELECT dealer_id, vdp FROM $marketchek_table WHERE (total_owned > 0 AND vdp != '' AND vdp IS NOT NULL AND trade IS NULL AND dealer_id > $start_id) LIMIT $limit;";
}

$result = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($result)) {
    $existing[$row['dealer_id']] = $row['vdp'];
}

foreach ($existing as $id => $vdp_url) {
    $data  = HttpGet($vdp_url, $proxy_list);
    $trade = '';

    if (preg_match($tv, $data)) {
        $trade .= 'TradeVue ';
    }

    if (preg_match($tg, $data)) {
        $trade .= 'TradeGauge ';
    }

    if (preg_match($ed, $data)) {
        $trade .= 'Edmunds ';
    }

    if (preg_match($es, $data)) {
        $trade .= 'Edmunds ';
    }

    if (preg_match($ti, $data)) {
        $trade .= 'Tradesii ';
    }

    if (preg_match($at, $data)) {
        $trade .= 'Accutrade ';
    }

    if (preg_match($tr, $data)) {
        $trade .= 'TradeRev ';
    }

    if (preg_match($tp, $data)) {
        $trade .= 'TradePending ';
    }

    if (preg_match($kb, $data)) {
        $trade .= 'KellyBlueBook ';
    }

    if (preg_match($tc, $data)) {
        $trade .= 'TrueCarTrade';
    }

    if (empty($trade)) {
        $trade = "N/A";
    }

    $query = "UPDATE $marketchek_table SET trade = '$trade' WHERE dealer_id = '$id';";

    $db_connect->query($query);
}

<?php

$base_dir    = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';
require_once __DIR__ . '/sitemap.php';

$CSV_DIR           = dirname(__DIR__) . '/reports/';
$marketcheck_trade = dirname(__DIR__) . '/reports/s_trade_marketcheck.csv';

$allactive_dealers = [];

$db_connect = new DbConnect('');
$fetch      = $db_connect->query("SELECT seller_name, inventory_url FROM marketcheck_dealers WHERE (num_found > 0 AND inventory_url IS NOT NULL);");

while ($row = mysqli_fetch_assoc($fetch)) {
    $allactive_dealers[$row['seller_name']] = 'https://www.' . $row['inventory_url'];
}

/*$outstream  = fopen($marketcheck_trade, 'w+');
fputcsv($outstream, ['Website', 'TradeVue', 'TradeGauge', 'Edmunds', 'Tradesii', 'Accutrade', 'TradeRev', 'TradePending', 'KellyBlueBook', 'TrueCarTrade', 'Remark']);
fclose($outstream);*/

//Trade In
$tv = '/.*tradevue.*/';                  //TradeVue
$tg = '/.*drivecarma\.ca\/.*/';          //TradeGauge
$ed = '/.*edmunds-media\.com\/.*/';      //Edmunds
$ti = '/.*tradesii\.com\/.*/';           //Tradesii
$at = '/.*accu\-trade\.com\/.*/';        //Accutrade
$tr = '/.*traderev\.com\/.*/';           //TradeRev
$tp = '/.*tradepending\.com\/.*/';       //TradePending
$kb = '/.*kbb\.com\/.*/';                //KellyBlueBook
$tc = '/.*truecar\.com\/.*/';            //TrueCarTrade

$outstream = fopen($marketcheck_trade, 'a+');

foreach ($allactive_dealers as $dealership => $inventory_url) {
    $inventory_url = "https://www.royalford.ca";
    $insert        = false;
    $TradeVue      = '';
    $TradeGauge    = '';
    $Edmunds       = '';
    $Tradesii      = '';
    $Accutrade     = '';
    $traderev      = '';
    $TradePending  = '';
    $KellyBlueBook = '';
    $TrueCarTrade  = '';
    $Remark        = '';

    //$url_types = classifyURLs(getSitemap(trim("{$inventory_url}/sitemap.xml")), ['trade' => '/(?:t|T)rade/']);

    //print_r(getSitemap(trim("{$inventory_url}/sitemap.xml")));
    //exit;

    foreach ($url_types as $currentUrl => $page_type) {
        /*if ($page_type == 'trade')
        {*/
        $insert = true;
        $Remark .= $currentUrl . ', ';

        if (@preg_match_all($tv, $currentUrl)) {
            $TradeVue = "YES";
            continue;
        }

        if (@preg_match_all($tg, $currentUrl)) {
            $TradeGauge = "YES";
            continue;
        }

        if (@preg_match_all($ed, $currentUrl)) {
            $Edmunds = "YES";
            continue;
        }

        if (@preg_match_all($at, $currentUrl)) {
            $Accutrade = "YES";
            continue;
        }

        if (@preg_match_all($tr, $currentUrl)) {
            $TradeRev = "YES";
            continue;
        }

        if (@preg_match_all($tp, $currentUrl)) {
            $TradePending = "YES";
            continue;
        }

        if (@preg_match_all($kb, $currentUrl)) {
            $KellyBlueBook = "YES";
            continue;
        }

        if (@preg_match_all($tc, $currentUrl)) {
            $TrueCarTrade = "YES";
            continue;
        }
        /*}*/
    }

    if ($insert) {
        //fputcsv($outstream, [$inventory_url, $TradeVue, $TradeGauge, $Edmunds, $Tradesii, $Accutrade, $TradeRev, $TradePending, $KellyBlueBook, $TrueCarTrade, $Remark]);
    }
}

fclose($outstream);

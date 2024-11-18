<?php

$base_dir    = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$summury = $base_dir . 'reports/s_trade_summury.csv';

$db_connect = new DbConnect('');
$query      = "SELECT * FROM s_trade_competetor WHERE (tradevue !='' OR tradegauge !='' OR edmunds !='' OR tradesii !='' OR accutrade !='' OR traderev !='' OR tradepending !='' OR kellybluebook !='' OR truecartrade !='');";
$fetch      = $db_connect->query($query);

$data = [];

$outstream = fopen($summury, 'w+');
fputcsv($outstream, ['Website', 'Trade Tools']);

while ($row = mysqli_fetch_assoc($fetch)) {
    $append = '';

    if ($row['tradevue'] == 'YES') {
        $append .= 'TradeVue ';
    }

    if ($row['tradegauge'] == 'YES') {
        $append .= 'TradeGauge ';
    }

    if ($row['edmunds'] == 'YES') {
        $append .= 'Edmunds ';
    }

    if ($row['tradesii'] == 'YES') {
        $append .= 'Tradesii ';
    }

    if ($row['accutrade'] == 'YES') {
        $append .= 'Accu-trade ';
    }

    if ($row['traderev'] == 'YES') {
        $append .= 'Traderev ';
    }

    if ($row['tradepending'] == 'YES') {
        $append .= 'Tradepending ';
    }

    if ($row['kellybluebook'] == 'YES') {
        $append .= 'KellyBlueBook ';
    }

    if ($row['truecartrade'] == 'YES') {
        $append .= 'TrueCarTrade ';
    }

    $data[$row['website']] = $append;

    fputcsv($outstream, [$row['website'], $append]);
}

fclose($outstream);

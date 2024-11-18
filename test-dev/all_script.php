<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";
$csv_file    = "{$adwords_dir}/caches/spincar.csv";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $smedia_website_providers, $smedia_trade_providers, $smedia_carchat_providers, $smedia_other_providers;

$all_scripts = array_merge($smedia_website_providers, $smedia_trade_providers, $smedia_carchat_providers, $smedia_other_providers);
natcasesort($all_scripts);

$dealers    = [];
$db_connect = new DbConnect('');
$fetch      = $db_connect->query("SELECT dealership, websites, website_provider, carchat_provider, trade FROM dealerships WHERE status = 'active' ORDER BY dealership ASC;");

while ($row = mysqli_fetch_assoc($fetch)) {
    $vendors = [];

    if ($row['website_provider'] && !empty($row['website_provider'])) {
        $vendors[] = $row['website_provider'];
    }

    if ($row['carchat_provider'] && !empty($row['carchat_provider'])) {
        $vendors[] = $row['carchat_provider'];
    }

    if ($row['trade'] && !empty($row['trade'])) {
        $vendors = array_unique(array_merge($vendors, explode(" ", $row['trade'])));
    }

    $dealers[$row['dealership']] = [
        'website' => $row['websites'],
        'vendors' => $vendors,
    ];
}

$dest      = __DIR__ . '/all_scripts_trial.csv';
$outstream = fopen($dest, 'w+');
fputcsv($outstream, ['dealership', 'website', 'vendors']);

foreach ($dealers as $key => $value) {
    $site         = $value['website'];
    $more_vendors = [];
    $resp         = HttpGet($site, true, true);

    if ($resp) {
        foreach ($all_scripts as $provider => $regex) {
            if (preg_match($regex, $resp)) {
                $more_vendors[] = $provider;
            }
        }
    }

    $dealers[$key]['vendors'] = array_unique(array_merge($dealers[$key]['vendors'], $more_vendors));

    fputcsv($outstream, [$key, $site, implode(" ", $dealers[$key]['vendors'])]);
}

fclose($outstream);
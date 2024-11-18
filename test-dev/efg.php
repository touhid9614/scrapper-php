<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";
$csv_file    = __DIR__ . "/trials.csv";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $smedia_website_providers, $smedia_trade_providers, $smedia_carchat_providers, $smedia_other_providers;

/*natcasesort($smedia_website_providers);
$outstream = fopen($csv_file, 'w+');
fputcsv($outstream, ['WEBSITE PROVIDER', 'REGEX']);
foreach ($smedia_website_providers as $key => $value) {
    fputcsv($outstream, [$key, $value]);
}
fclose($outstream);
exit();*/

$web_providers   = $smedia_website_providers;
$trade_providers = $smedia_trade_providers;
$chat_providers  = $smedia_carchat_providers;

$all_scripts = array_merge($smedia_website_providers, $smedia_trade_providers, $smedia_carchat_providers, $smedia_other_providers);
natcasesort($all_scripts);

$data          = [];
$trial_dealers = [];
$db_connect    = new DbConnect('');

$query1 = "SELECT dealership, websites, website_provider, trade, carchat_provider FROM dealerships WHERE status IN ('active', 'trial');";
$fetch1 = $db_connect->query($query1);

while ($row1 = mysqli_fetch_assoc($fetch1)) {
    $data[$row1['dealership']] = [
        'websites'         => $row1['websites'],
        'website_provider' => $row1['website_provider'],
        'trade'            => $row1['trade'],
        'carchat_provider' => $row1['carchat_provider'],
    ];
}

foreach ($data as $key => $value) {
    $root_reponse = HttpGet($value['websites'], true, true);

    if (!$root_reponse) {
        $db_connect->query("UPDATE dealerships SET website_provider = 'SITE_UNRESPONSIVE' WHERE dealership = '$key';");
        continue;
    }

    // WEBSITE PROVIDER
    if (empty($value['website_provider'])) {
        foreach ($web_providers as $provider => $regex) {
            if (preg_match($regex, $root_reponse)) {
                $data[$key]['website_provider'] = $provider;
                // UPDATE DB
                $db_connect->query("UPDATE dealerships SET website_provider = '$provider' WHERE dealership = '$key';");
                break;
            }
        }
    }

    // TRADE PROVIDER
    if (empty($value['trade'])) {
        $trade = '';

        foreach ($trade_providers as $provider => $regex) {
            if (preg_match($regex, $root_reponse)) {
                $trade .= $provider . ' ';
            }
        }

        // try forcibly from most common url
        if (empty($trade)) {
            $url_parts      = parse_url($inventory_url);
            $host           = $url_parts['host'];
            $scheme         = $url_parts['scheme'];
            $trade_url      = "{$scheme}://{$host}/value-your-trade/";
            $trade_response = HttpGet($trade_url, true, true);

            if ($trade_response) {
                foreach ($trade_providers as $provider => $regex) {
                    if (preg_match($regex, $trade_response)) {
                        $trade .= $provider . ' ';
                    }
                }
            }

            // Search for trade tool url in sitemap
            if (empty($trade)) {
                $sitemap_url = "{$scheme}://{$host}/sitemap.xml";
                $resp        = HttpGet($sitemap_url, true, true);

                if (!$resp) {
                    $sitemap_url = "{$scheme}://{$host}/sitemap_index.xml";
                }

                $trade_regex = '/(trade|sell|offer|instant|value)/i'; // sell, offer, trade
                $url_types   = classifyURLs(getSitemap(trim($sitemap_url)), ['trade' => $trade_regex]);

                foreach ($url_types as $currentUrl => $page_type) {
                    if ($page_type == 'trade') {
                        $current_response = HttpGet($currentUrl, true, true);

                        foreach ($trade_providers as $provider => $regex) {
                            if (preg_match($regex, $current_response)) {
                                $trade .= $provider . ' ';
                            }
                        }
                    }
                }
            }
        }

        if (!empty($trade)) {
            $data[$key]['trade'] = $trade;
            // UPDATE DB
            $db_connect->query("UPDATE dealerships SET trade = '$trade' WHERE dealership = '$key';");
        }
    }

    // CARCHAT PROVIDER
    if (empty($value['carchat_provider'])) {
        foreach ($chat_providers as $provider => $regex) {
            if (preg_match($regex, $root_reponse)) {
                $data[$key]['carchat_provider'] = $provider;
                // UPDATE DB
                $db_connect->query("UPDATE dealerships SET carchat_provider = '$provider' WHERE dealership = '$key';");
                break;
            }
        }
    }

    // ALL SCRIPTS
    $more_vendors = [];

    foreach ($all_scripts as $provider => $regex) {
        if (preg_match($regex, $root_reponse)) {
            $more_vendors[] = $provider;
        }
    }

    if (count($more_vendors) > 0) {
        $vendors = implode(" ", array_unique($more_vendors));
        $db_connect->query("UPDATE dealerships SET vendors = '$vendors' WHERE dealership = '$key';");
    }
}

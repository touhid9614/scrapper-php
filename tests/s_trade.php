<?php

require_once dirname(__DIR__) . '/adwords3/config.php';
require_once dirname(__DIR__) . '/adwords3/utils.php';
require_once __DIR__ . '/sitemap.php';

$CSV_DIR = dirname(__DIR__) . '/reports/';

global $scrapper_configs;

$site_list = [];

foreach ($scrapper_configs as $scraper_name => $scraper_config) {
    $vdp_url_regex = '';

    if (isset($scraper_config['entry_points'])) {
        foreach ($scraper_config['entry_points'] as $urls) {
            if (!is_array($urls)) {
                $urls = [$urls];
            }

            foreach ($urls as $url) {
                $domain             = GetDomain($url);
                $scheme             = substr($url, 0, stripos($url, ':', 0));
                $domain             = "{$scheme}://$domain";
                $site_list[$domain] = $scraper_name;
            }
        }
    }
}

$outstream = fopen($CSV_DIR . 's_trade.csv', 'w+');
fputcsv($outstream, ['Dealership', 'Website', 'Trading URL', 'Report']);

foreach ($site_list as $url => $scraper_name) {
    $url_types = classifyURLs(getSitemap(trim("{$url}/sitemap.xml")), ['trade' => '/(?:t|T)rade/']);

    foreach ($url_types as $currentUrl => $page_type) {
        if ($page_type == 'trade') {
            fputcsv($outstream, [$scraper_name, $url, $currentUrl, 'Trading url exists']);
            break;
        }
    }
}

fclose($outstream);

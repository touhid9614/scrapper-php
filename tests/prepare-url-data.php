<?php

require_once dirname(__DIR__) . '/adwords3/config.php';
require_once dirname(__DIR__) . '/adwords3/utils.php';

$CSV_DIR = dirname(__DIR__) . '/reports/url_data/';

global $scrapper_configs;

$site_list = [];

/*foreach ($scrapper_configs as $scraper_name => $scraper_config)
{
$vdp_url_regex = '';

if (isset($scraper_config['vdp_url_regex']))
{
$vdp_url_regex = $scraper_config['vdp_url_regex'];
}

if (!$vdp_url_regex)
{
continue;
}

if (isset($scraper_config['entry_points']))
{
foreach ($scraper_config['entry_points'] as $urls)
{
if (!is_array($urls))
{
$urls = [$urls];
}

foreach ($urls as $url)
{
$domain = GetDomain($url);
$scheme = substr($url, 0, stripos($url, ':', 0));
$domain = "{$scheme}://$domain";
$site_list[$domain] =
[
'dealership' => $scraper_name,
'vdp_regex' => $vdp_url_regex
];
}
}
}
}*/

/*foreach ($site_list as $url => $data)
{
echo $url . PHP_EOL;
echo $data['vdp_regex'] . PHP_EOL;

$url_types = classifyURLs(excludeBegining(getSitemap(trim("{$url}/sitemap.xml")), $url), ['vdp' => $data['vdp_regex']]);

$outstream = fopen($CSV_DIR . $data['dealership'] . '.csv', 'w+');
fputcsv($outstream, ['url', 'page_type']);

foreach ($url_types as $currentUrl => $page_type)
{
fputcsv($outstream, [$currentUrl, $page_type]);
}

fclose($outstream);
}

echo "Scraper count: " . count($scrapper_configs) . PHP_EOL;
echo "Valid for data collection: " . count($site_list) . PHP_EOL;*/

https://www.coastmountaingm.com/en/new-catalog/chevrolet/2022-chevrolet-trax-id18758

$sitemap       = 'https://www.bmwmcseattle.com/SiteMapContent.xml-sincro.xml';
$vdp_url_regex = '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i';
$get_site_map  = getSitemap("{$sitemap}", false);
// $url_types 	   = classifyURLs($get_site_map, ['vdp' => $vdp_url_regex]);

/*$outstream = fopen($CSV_DIR . 'farmworld.csv', 'w+');
fputcsv($outstream, ['url', 'page_type']);

foreach ($url_types as $currentUrl => $page_type)
{
fputcsv($outstream, [$currentUrl, $page_type]);
}*/

// print_r($get_site_map);
print_r($get_site_map);

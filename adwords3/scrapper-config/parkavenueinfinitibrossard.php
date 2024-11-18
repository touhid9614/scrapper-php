<?php

global $scrapper_configs;
$scrapper_configs["parkavenueinfinitibrossard"] = array(
    'entry_points' => array(
        'used' => 'https://groupeparkavenue.com/en/used-vehicles/inventory?f%5B0%5D=dealership%3A3790'
    ),
    'picture_selectors' => ['.overlay img'],
    'picture_nexts' => ['.bx-wrapper__small-next'],
    'picture_prevs' => ['.bx-wrapper__small-prev'],
    'vdp_url_regex' => '/\/en\/inventory\/[0-9]{4}-/i',
    'use-proxy' => true,
    'details_start_tag' => '<div class="inventory-table-wrapper toggleable-layout-listing list">',
    'details_end_tag' => '<footer class="l-footer"',
    'details_spliter' => '<div class="inventory-listing inventory-table__row',
    'data_capture_regx' => array(
        'stock_number' => '/Stock Number<\/span><span[^>]+><span[^>]+>(?<stock_number>[^<]+)/',
        'url' => '/name list-view-only">\s*<span class="field-content"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'title' => '/name list-view-only">\s*<span class="field-content"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'year' => '/name list-view-only">\s*<span class="field-content"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make' => '/name list-view-only">\s*<span class="field-content"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/name list-view-only">\s*<span class="field-content"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'price' => '/class="field-content">(?<price>\$[0-9,]+)/',
        'engine' => '/Engine<\/span><span[^>]+><span[^>]+>(?<engine>[^<\/]+)/',
        'kilometres' => '/Kilometers<\/span><span[^>]+><span[^>]+>(?<kilometres>[^<\/]+)/',
        'transmission' => '/Transmission<\/span><span[^>]+><span[^>]+>(?<transmission>[^<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<li class="pager__item pager__item--next"><a href="(?<next>[^"]+)"/',
    'images_regx' => '/<li><picture\s*>\s*.*\s*<source srcset="(?<img_url>[^?]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);


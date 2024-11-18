<?php

global $scrapper_configs;

$scrapper_configs['novlanbros'] = array(
    'entry_points' => array(
        'new' => 'https://novlanbros.com/inventory/list/?filter=[New]&p=1',
        'used' => 'https://novlanbros.com/inventory/list/?filter=[Used]&p=1',
    ),
    'vdp_url_regex' => '/\/inventory\/details\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.cardealer_thumbnail.row div a'],
    'picture_nexts' => ['#fbplus-right-ico'],
    'picture_prevs' => ['#fbplus-left-ico'],
    'details_start_tag' => '<div class="list"',
    'details_end_tag' => '<footer id="footer"',
    'details_spliter' => '<div class="vehicleModule"',
    'data_capture_regx' => array(
        'url' => '/<a itemprop="url" class="" href="(?<url>[^"]+)">/',
        'title' => '/<a itemprop="url" class="" href="(?<url>[^"]+)"><h4 itemprop="name">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
        'year' => '/<a itemprop="url" class="" href="(?<url>[^"]+)"><h4 itemprop="name">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
        'make' => '/<a itemprop="url" class="" href="(?<url>[^"]+)"><h4 itemprop="name">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
        'model' => '/<a itemprop="url" class="" href="(?<url>[^"]+)"><h4 itemprop="name">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
        'price' => '/<span itemprop="price">(?<price>[^<]+)/',
        'engine' => '/Engine:(?<engine>[^<]+)/',
        'kilometres' => '/Odometer:(?<kilometres>[^<]+)/',
        'exterior_color' => '/Exterior:(?<exterior_color>[^<]+)/',
        'stock_number' => '/Stock Number:<[^>]+>(?<stock_number>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/Transmission<\/b>:(?<transmission>[^<]+)/',
        'interior_color' => '/Interior Color<\/b>:(?<interior_color>[^<]+)/',
        'price' => '/Internet Price:<\/div>\s*<[^>]+>\s*<[^>]+>(?<price>[^<]+)/',
    ),
    'next_query_regx'   => '/<b>[0-9]<\/b><\/a><\/li><li><a href="[^p]+p[^p]+(?<param>p)=(?<value>[0-9]*)"/',
    'images_regx' => '/data-image="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);




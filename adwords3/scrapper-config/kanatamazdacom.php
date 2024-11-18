<?php

global $scrapper_configs;

$scrapper_configs['kanatamazdacom'] = array(
    'entry_points' => array(
        'new' => 'https://www.kanatamazda.com/new/',
        'used' => 'https://www.kanatamazda.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.thumb li img'],
    'picture_nexts' => ['.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon-chevron-left'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer',
    'details_spliter' => '<div itemprop="ItemOffered"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)" history.*title="/',
        'year' => '/itemprop=\'releaseDate\'>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\'>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\'>(?<model>[^\s]+)/',
        'price' => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
        'stock_number' => '/STK#\s*(?<stock_number>[^\/]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
);



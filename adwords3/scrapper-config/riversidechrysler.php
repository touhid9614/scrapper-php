<?php

global $scrapper_configs;

$scrapper_configs['riversidechrysler'] = array(
    'entry_points' => array(
        'new' => 'https://www.riversidechrysler.ca/new/',
        'used' => 'https://www.riversidechrysler.ca/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],

    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="opt-3 wp"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12">',

    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^<]+)/',
        'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^<]+)/',
        'price' => '/Price:[^>]+>[^>]+>[^>]+>[^>]+>\s*[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)"/'
);
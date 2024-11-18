<?php

global $scrapper_configs;

$scrapper_configs['vwbillings'] = array(
    'entry_points' => array(
        'new' => 'https://www.vwbillings.com/new-inventory/index.htm',
        'used' => 'https://www.vwbillings.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/final-price"><span[^>]+>[^<]+<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/<a href="(?<img_url>[^\?]+)\?impolicy=resize&w=650" class="js-link">/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);


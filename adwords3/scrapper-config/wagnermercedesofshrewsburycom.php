<?php

global $scrapper_configs;

$scrapper_configs['wagnermercedesofshrewsburycom'] = array(
    'entry_points' => array(
        'new' => 'https://www.wagnermercedesofshrewsbury.com/new-inventory/index.htm',
        'used' => 'https://www.wagnermercedesofshrewsbury.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/<a href="(?<img_url>[^\?]+)\?impolicy=resize&w=650" class="js-link">/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

<?php

global $scrapper_configs;

$scrapper_configs['recar'] = array(
    'entry_points' => array(
        'used' => 'https://www.recar.ca/used/'
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['div.slider-hortizontal-conteiner .thumb li'],
    'picture_nexts' => ['.next em'],
    'picture_prevs' => ['.prev em'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/itemprop="url"\s*onclick.*href="(?<url>[^\"]+)/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        // 'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
        'price' => '/Internet Price:[^>]+>[^>]+>[^>]+>\s*(?:<var>|)[^>]+>(?<price>[^<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^>]+><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/onerror="imgError[^"]+"\s*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);

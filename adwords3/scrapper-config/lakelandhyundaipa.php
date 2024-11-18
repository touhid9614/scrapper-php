<?php
    global $scrapper_configs;
    $scrapper_configs['lakelandhyundaipa'] = array(
       'entry_points' => array(
        'new' => 'https://www.lakelandhyundaipa.com/new/',
        'used' => 'https://www.lakelandhyundaipa.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    // 'refine' => false,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon-chevron-left'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<div class="ajax-loading"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'make'                => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model'               => '/itemprop=\'model\' notranslate><var>(?<model>[^<]+)/',
        'price'               => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
        // 'stock_type' => '/"condition":"(?<stock_type>[^"]+)/',
        // 'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        // 'vin'       => '/VIN:[^>]+>[^>]+>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'price' => '/price:\s*\'(?<price>[^\']+)[^\s*]/',
        'year' => '/year:\s*\'(?<year>[^\']+)[^\s*]/',
        // 'make' => '/make:\s*\'(?<make>[^\']+)[^\s*]/',
        // 'model' => '/model:\s*\'(?<model>[^\']+)[^\s*]/',
        'trim' => '/trim:\s*\'(?<trim>[^\']+)[^\s*]/',
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
        'vin' => '/<input type="hidden" id="vin-(?<vin>[^\']+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/<img onerror="imgError\(this\)\;" (?:data-src|src)="(?<img_url>[^"]+)/'
);

<?php

global $scrapper_configs;
$scrapper_configs["bannistergmdccom"] = array(
    'entry_points' => array(
         'used' => 'https://www.bannistergmdc.com/used/dealer/Bannister+GM+Dawson+Creek',
         'new'  => 'https://www.bannistergmdc.com/new/',
    ),
    'refine' => false,
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'srp_page_regex'      => '/com\/(?:new|used)/',
    'use-proxy' => true,
    'proxy-area'    => 'CA',
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => 'class="modal-footer">',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'vin'   => '/"vin":"(?<vin>[^"]+)/',
        'year' => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number' => '/itemprop="sku">\s*(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain' => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'trim' => '/trim:\s*\'(?<trim>[^\']+)/',
        'stock_number' => '/itemprop="sku">\s*(?<stock_number>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin'                 => '/\&vin=(?<vin>[^\&]+)/',
        'fuel_type'           => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/onerror="imgError\(this\);"\s*(?:data-src|src)="(?<img_url>[^"]+)"/'
);


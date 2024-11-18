<?php
global $scrapper_configs;
 $scrapper_configs["leggatca"] = array( 
	'entry_points' => array(
        'used' => 'https://www.leggat.ca/used/',
        'new' => 'https://www.leggat.ca/new/',
        
    ),
    'refine' => false,
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<div class="ajax-loading"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'vin'   => '/"vin":"(?<vin>[^"]+)/',
        'year' => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain' => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin'                 => '/\&vin=(?<vin>[^\&]+)/',
        'fuel_type'           => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/onerror="imgError\(this\)\;" (?:data-src|src)="(?<img_url>[^"]+)/'
);


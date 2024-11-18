<?php
global $scrapper_configs;
$scrapper_configs["lakeheadmotorsca"] = array( 
	'entry_points' => array(
            'new'  => 'https://www.lakeheadmotors.ca/new/',
            'used'  => 'https://www.lakeheadmotors.ca/used/'
        ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.thumb li img'],
    'picture_nexts' => ['.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon-chevron-left'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp"',
    'details_spliter' => '<div itemprop="ItemOffered"',
    'data_capture_regx' => array(
        'url' => '/role="button" href="(?<url>[^"]+)"/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'stock_number' => '/STK#\s*(?<stock_number>[^\/]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/itemprop="sku">\s*(?<stock_number>[^<]+)/',     
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/vin=(?<vin>[^\&]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
);



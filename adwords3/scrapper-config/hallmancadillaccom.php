<?php
global $scrapper_configs;
$scrapper_configs["hallmancadillaccom"] = array( 
	 'entry_points' => array(
            'new' => 'https://www.hallmancadillac.com/new/',
            'used' => 'https://www.hallmancadillac.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'=> false,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate>(?<model><var>[^\<]+)/',
        'price' => '/<span itemprop="price"\s*content="[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
     //   'price' => '/Cash<\/span><span[^>]+>\s*(?<price>\$[0-9,]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/onerror="imgError\(this\);"\s*(?:data-src|src)="(?<img_url>[^"]+)"/'
);



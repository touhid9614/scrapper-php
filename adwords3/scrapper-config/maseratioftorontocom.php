<?php
global $scrapper_configs;
$scrapper_configs["maseratioftorontocom"] = array( 
	 'entry_points' => array(
       'new' => 'https://www.maseratioftoronto.com/new/Maserati.html',
        'used' => 'https://www.maseratioftoronto.com/used/Maserati.html',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.thumb li img'],
    'picture_nexts' => ['.next'],
    'picture_prevs' => ['.prev'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style=\'/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
    //'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)/'
);




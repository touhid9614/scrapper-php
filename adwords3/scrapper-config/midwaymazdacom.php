<?php
global $scrapper_configs;
$scrapper_configs["midwaymazdacom"] = array( 
	    'entry_points' => array(
        'new' => 'https://www.midwaymazda.com/new/',
        'used' => 'https://www.midwaymazda.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.thumb li img'],
    'picture_nexts' => ['.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon-chevron-left'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer',
    'details_spliter' => '<div itemscope',
    'data_capture_regx' => array(
        'url' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*itemprop="url".*href="(?<url>[^"]+)">\s*[^>]+>/',
        'year' => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer[^>]+>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model[^>]+>(?<model>[^\s]+)/',
        'price' => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',       
         'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'vin' => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
);



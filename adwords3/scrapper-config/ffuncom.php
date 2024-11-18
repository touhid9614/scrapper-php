<?php
global $scrapper_configs;
$scrapper_configs["ffuncom"] = array( 
	 'entry_points' => array(
            'used'  => 'https://inventory.ffun.com/used/',
            'new'   => 'https://inventory.ffun.com/new/',
            
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb li img'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div data-elementor-type="footer"',
        'details_spliter'   => '<div itemprop="ItemOffered"',
        'data_capture_regx' => array(
        'url'                 => '/href="(?<url>[^"]+)">\s*<\/a>/',
        'year'                => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
       
            'make'                => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model\' notranslate>(?<model>[^<]+)/',
        'price' => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
        'stock_number' => '/STK#\s*(?<stock_number>[^\/]+)/',
    ),
    'data_capture_regx_full' => array(
    	
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/vin:\s*\'(?<vin>[^\']+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
);

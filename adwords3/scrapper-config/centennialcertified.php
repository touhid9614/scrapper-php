<?php

global $scrapper_configs;
$scrapper_configs["centennialcertified"] = array( //centernnial certified is redirected to below url and we have also centennialautogroup separate dealership thats why i add this url  in custom dealer to track analytics. //
    'entry_points' => array(
        'used' => 'https://www.centennialautogroup.ca/en/centennialcertifiedofcharlottetown-inventory'
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used|certified)-inventory\/[^\/]+\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,

    'picture_selectors' => ['.slide a img'],
    'picture_nexts' => ['div a.next'],
    'picture_prevs' => ['div a.previous'],
    
    'details_start_tag' => '<section class="inventory-listing__content',
    'details_end_tag' => '<section class="inventory-listing__form"',
    'details_spliter' => '<article class="inventory-list-layout-wrapper',
    'data_capture_regx' => array(
        'url' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'title' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'year' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'make' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'model' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'price' => '/Available at<\/span>\s*<[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/<span data-theme-style="vehiclePreview_secondaryColor">(?<kilometres>[0-9 ,]+)\s*KM/',
        'stock_number' => '/Inventory\s*#[^>]+>\s*<[^>]+>(?<stock_number>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        
       
       // 'engine' => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>\s*<[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color:[^>]+>\s*<[^>]+>(?<exterior_color>[^<]+)/',
        'vin'            => '/VIN\s*#[^>]+>\s*<span>(?<vin>[^<]+)/',
        'body_style' => '/Bodystyle:[^>]+>\s*<[^>]+>(?<body_style>[^<]+)/',
    ),
  'next_page_regx' => '/<a class="pagination__page-arrows-text\s*"\s*href="(?<next>[^"]+)"\s*[^>]+>\s*<[^>]+>Next/',
    'images_regx' => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)"\s*alt="/',
   // 'images_fallback_regx' => '/<meta property="og:image"content="(?<img_url>[^"]+)/'
);
// add_filter('filter_centennialcertified_car_data', 'filter_centennialcertified_car_data');
    
//     function filter_centennialcertified_car_data($car_data) 
//     {
//         //taking all cars except Corvette
       
//         if($car_data['stock_number']==='U934') 
//         {
//             slecho("Excluding car that has stock number U934 ,{$car_data['url']}");
//             return null;
//         }
//         return $car_data;
//     }
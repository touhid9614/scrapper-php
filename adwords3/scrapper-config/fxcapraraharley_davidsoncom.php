<?php
global $scrapper_configs;
$scrapper_configs["fxcapraraharley_davidsoncom"] = array( 
	 "entry_points" => array(  
         'used' => 'https://fxcapraraharley-davidson.com/pre-owned-inventory/?page=1',
        'new' => 'https://fxcapraraharley-davidson.com/new-inventory/?page=1',
      
    ),
    'vdp_url_regex' => '/inventory\//i',
    'use-proxy' => false,
    'refine'=>false,
  'picture_selectors' => ['.r58-lightbox--stage img'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<ul id="inventoryBikesList',
    'details_end_tag' => '<footer class="',
    'details_spliter' => '<li class="inventoryList-bike',
    'data_capture_regx' => array(
        'url' => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'year' => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'make' => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'model' => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'price' => '/inventoryList-bike-details-price ">(?<price>[^<]+)/', ///dealer price///
        'stock_number' => '/Stock number:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
       
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/Mileage:[^>]+>\s*[^>]+>(?<kilometres>[0-9]+)/',
        'vin' => '/VIN number:[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'exterior_color' => '/>Color[^>]+>\s*[^>]+>/',
        'description'  => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_query_regx' => '/title="Next page">[^>]+>[^>]+>[^>]+><a href="[^\?]+\?(?<param>page)=(?<value>[0-9]*)"/',
    'images_regx' => '/data-lightbox-prevent href="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);


add_filter('filter_fxcapraraharley_davidsoncom_car_data', 'filter_fxcapraraharley_davidsoncom_car_data');
function filter_fxcapraraharley_davidsoncom_car_data($car_data) {
   
    $car_data['make'] = str_replace('&quot;', '"', $car_data['make']);
    $car_data['make'] = str_replace('™', '', $car_data['make']);
    $car_data['make'] = str_replace('®', '', $car_data['make']);
    $car_data['make'] = str_replace('Â', '', $car_data['make']);
    $car_data['make'] = str_replace('â„¢', '', $car_data['make']);
   
    $car_data['model'] = str_replace('&quot;', '"', $car_data['model']);
    $car_data['model'] = str_replace('™', '', $car_data['model']);
    $car_data['model'] = str_replace('®', '', $car_data['model']);
    $car_data['model'] = str_replace('Â', '', $car_data['model']);
    $car_data['model'] = str_replace('â„¢', '', $car_data['model']);
 
    $car_data['description'] = str_replace('&quot;', '"', $car_data['description']);
    $car_data['description'] = str_replace('™', '', $car_data['description']);
    $car_data['description'] = str_replace('®', '', $car_data['description']);
    $car_data['description'] = str_replace('Â', '', $car_data['description']);
    $car_data['description'] = str_replace('â„¢', '', $car_data['description']);
    
    
    return $car_data;
}

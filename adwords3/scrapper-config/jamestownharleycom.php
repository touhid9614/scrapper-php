<?php
global $scrapper_configs;
$scrapper_configs["jamestownharleycom"] = array( 
	"entry_points" => array(
	     'used' => 'https://jamestownharley.com/pre-owned-inventory',
         'new' => 'https://jamestownharley.com/new-inventory',  
    ),
    'vdp_url_regex' => '/\/inventory\/[^\/]+\/(?:new|used)-[0-9]{4}-/',
    'refine' => false,
    'use-proxy' => true,
    'details_start_tag' => '<section class="mainContent-wrapper">',
    'details_end_tag'   => '<footer class="container-fullWidth">',
	'details_spliter'   => '<li class="inventoryList-bike">',
    'picture_selectors' => ['.r58-slider-slide'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    'data_capture_regx' => array(
        'url'                 => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'year'                => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'make'                => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'model'               => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'kilometres'          => '/Mileage:<\/td>[^>]+>(?<kilometres>[0-9,]+)/',
        'stock_number'        => '/Stock number:<\/td>[^>]+>(?<stock_number>[^<]+)/',
        'exterior_color' => '/Color:<\/td>\s*<td>(?<exterior_color>[^<]+)/',
          'price' => '/<span class="inventoryList-bike-details-price ">(?<price>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(        
       
      'vin' => '/VIN number:<\/td>\s*<td>(?<vin>[^<]+)/',
      //'description' => '/<meta property="og:description" content="(?<description>[^"]+)/',
    ) , 
    'next_page_regx'    => '/<a\s*href="(?<next>[^"]+)"\s*data-page[^"]+"[^"]+"\s*title="Next page"/',
    'images_regx'       => '/data-lightbox-prevent href="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter('filter_jamestownharleycom_car_data', 'filter_jamestownharleycom_car_data');

function filter_jamestownharleycom_car_data($car_data) {
  
    $car_data['vin']=md5($car_data['url']);
    $car_data['make'] = str_replace('®', '', $car_data['make']);
    $car_data['model'] = str_replace('®', '', $car_data['model']);
    $car_data['make'] = str_replace('Â', '', $car_data['make']);
    $car_data['model'] = str_replace('Â', '', $car_data['model']);
    $car_data['exterior_color'] = str_replace('&', '', $car_data['exterior_color']);
    return $car_data;
}

   add_filter("filter_jamestownharleycom_next_page", "filter_jamestownharleycom_next_page",10,2);
    
    function filter_jamestownharleycom_next_page($next,$current_page) {


     $next = $current_page . "?page=2";

        if ($next == "https://jamestownharley.com/pre-owned-inventory?page=2" || $next == "https://jamestownharley.com/new-inventory?page=2") 
        {
            return $next;
        }
     
    }





<?php
global $scrapper_configs;
$scrapper_configs["capecodharleycom"] = array( 
	'entry_points' => array(
        'used' => 'https://capecodharley.com/default-asp-page-xpreownedinventory',
        'new'  => 'https://capecodharley.com/default-asp-page-xallinventory-ay-2018-2019',
        
    ),
    'vdp_url_regex' => '/\/inventory\//i',

    'use-proxy' => true,
    'refine'=>false,
    'details_start_tag' => '<section class="mainContent-wrapper">',
    'details_end_tag'   => '<footer class="container-fullWidth">',
	'details_spliter'   => '<li class="inventoryList-bike">',


    'picture_selectors' => ['.r58-slider-slide'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    
    'data_capture_regx' => array(
        'url'                 => '/details-title">\s*<a href="(?<url>[^"]+)">/',
        'year'                => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'make'                => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'model'               => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'price'               => '/<span\s*class="inventoryList-bike-details-price\s*">(?<price>[^<]+)/',
        'kilometres'          => '/Mileage:<\/td>[^>]+>(?<kilometres>[0-9,]+)/',
        'stock_number'        => '/Stock number:<\/td>[^>]+>(?<stock_number>[^<]+)/',
        'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'exterior_color'      => '/Colour:<\/td>[^>]+>(?<exterior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(  

             'stock_number'  => '/Stock number:<\/td>\s*<td>(?<stock_number>[^<]+)/',
             'year'          => '/Year:<\/td>\s*<td>(?<year>[^<]+)/',
             'vin'           => '/VIN number:[^>]+>\s*[^>]+>(?<vin>[^<]+)/'
    ) , 
    'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" title="Next page">/',
    'images_regx'       => '/data-lightbox-prevent href="(?<img_url>[^"]+)"/'
);

add_filter('filter_capecodharleycom_car_data', 'filter_capecodharleycom_car_data');


function filter_capecodharleycom_car_data($car_data) {
    
    $car_data['make'] =preg_replace('/[^A-Za-z0-9 -]/', '', $car_data['make']);
    $car_data['model']=preg_replace('/[^A-Za-z0-9 -]/', '', $car_data['model']);

    return $car_data;
}

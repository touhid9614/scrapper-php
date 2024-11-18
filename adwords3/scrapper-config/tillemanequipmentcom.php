<?php
global $scrapper_configs;
$scrapper_configs["tillemanequipmentcom"] = array( 
	'entry_points' => array(
        'used' => 'https://www.tillemanequipment.com/inventory/?/listings/farm-equipment/for-sale/list?pcid=3026721&etid=1&lo=4&snai=0&ftr=1&sfc=0',
    ),
    
    'vdp_url_regex' => '/is-equipment-listings\/view\//i',
    'use-proxy' => true,
    'refine' => false,
    // 'no_scrap' => true,
    
    'details_start_tag' => '<div class="listings-list  hosted-theme  ">',
    'details_end_tag' => '<div class="pagination form-pagination">',
    'details_spliter' => '<div class="listing-boxed listing"',

    'data_capture_regx' => array(
        'url'           => '/<div class="listing-boxed-details"><h2><a href="(?<url>[^"]+)"/',
        'description'   => '/listing-boxed-description">(?<description>[^<]+)/',
        
    ),

    'data_capture_regx_full' => array(
        'year'          => '/Year<\/div>[^>]+>(?<year>[0-9]{4})/',
        'make'          => '/Manufacturer<\/div>[^>]+>(?<make>[^<]+)/',
        'model'         => '/Model<\/div>[^>]+>(?<model>[^<]+)/',
        'stock_number'  => '/Serial Number<\/div>[^>]+>(?<stock_number>[^<]+)/',
        'vin'           => '/Serial Number<\/div>[^>]+>(?<vin>[^<]+)/',
        'price'         => '/<span class="price-value">(?<price>[^<]+)/',
        
    ),

    'next_page_regx'    => '/<link rel="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/class="carousel-image"><img src="(?<img_url>[^"]+)"/',
    
);

add_filter("filter_tillemanequipmentcom_car_data", "filter_tillemanequipmentcom_car_data");

function filter_tillemanequipmentcom_car_data($car)
{
    

    return $car;
}
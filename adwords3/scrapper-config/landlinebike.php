<?php
global $scrapper_configs;
$scrapper_configs["landlinebike"] = array( 
	'entry_points' => array(
            'new'   => 'https://landline.bike/products/landline-runner?variant=39458355478702',
            
        ),
        'vdp_url_regex'     => '/\/products\/landline-runner/i',
        'use-proxy' => true,
    
        'refine' => false,
        'details_spliter' => 'End Google Tag Manager',
        'data_capture_regx' => array(
            'make'          => '/title>\s*(?<make>[^\s]+)/',
            'model'         => '/title>\s*(?<make>[^\s]+)\s*(?<model>[^\&]+)/',
            'price'         => '/<span data-product-price >(?<price>[^<]+)/',
            'description'    => '/<p data-mce-fragment="1">(?<description>[^<]+)/',
            'url'           => '/<input type="hidden" name="return_to" value="(?<url>[^\&]+)/'
        ),
        'data_capture_regx_full' => array(
        ),
        'images_regx'       => '/data-image-src="(?<img_url>[^"]+)"/',
    );

add_filter('filter_landlinebike_car_data', 'filter_landlinebike_car_data');


function filter_landlinebike_car_data($car_data) {
    //taking all cars except Corvette

   $car_data['year'] = "2023";
   $car_data['make'] = "Landline";
   $car_data['model']= "Runner Electric Bike";
   $car_data['title']= "Landline Runner Electric Bike";

    return $car_data;
}


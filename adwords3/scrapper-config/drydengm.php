<?php

global $scrapper_configs;

$scrapper_configs['drydengm'] = array(
    'entry_points'           => array(
        'new'  => 'https://www.drydengm.ca/inventory/new/',
        'used' => 'https://www.drydengm.ca/inventory/used/',
    ),
    'use-proxy'              => true,
    'refine'                 => false,
    'vdp_url_regex'          => '/\/inventory\//i',
    'srp_page_regex'         => '/\/inventory\/(?:New|certified|Used)\//i',
    'picture_selectors'      => ['.slick-slide img'],
    'picture_nexts'          => ['.slick-next'],
    'picture_prevs'          => ['.slick-prev'],
    'details_start_tag'      => 'class="srpVehicles__wrap">',
    'details_end_tag'        => 'class="disclaimer__wrap">',
    'details_spliter'        => 'id="carbox',
    'data_capture_regx'      => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres'     => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
        'engine'         => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
        'transmission'   => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/',
        'vin'            => '/data-vehicle="vin"[^>]+>(?<vin>[^<]+)/',
        'stock_number'   => '/"sku":"(?<stock_number>[^"]+)/',
        'year'           => '/class="vehicle-title--year">(?<year>[^<]+)/',
        'stock_type'     => '/"itemCondition":"(?<stock_type>[^"]+)/',
        'make'           => '/class="notranslate vehicle-title--make ">(?<make>[^<]+)/',
        'model'          => '/class="notranslate vehicle-title--model ">(?<model>[^<]+)/',
        'trim'           => '/class="notranslate vehicle-title--trim ">(?<trim>[^<]+)/',
        'body_style'     => '/class="title-standardbody vehicle-title--subtitle-item">(?<body_style>[^<]+)/',
        'drivetrain'     => '/class="title-drivetrain vehicle-title--subtitle-item">(?<drivetrain>[^<]+)/',
        'price'          => '/window.display_price=(?<price>[^\;]+)/',
        'description'    => '/name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx'         => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx'            => '/class="img-fluid[^"]+"\s*alt="[^"]+"\s*src="[^"]+"\s*data-src="(+)"/',
    'images_fallback_regx'   => '/property="og:image" content="(?<img_url>[^"]+)"/',
);

//https://app.guidecx.com/app/projects/3170c9f3-3150-4378-9190-0e90b4f83256/notes
//we have a task to remove this filter from the scraper . 

// add_filter('filter_drydengm_car_data', 'filter_drydengm_car_data', 10, 1);

// function filter_drydengm_car_data($car_data) {
//     // filter body style
//     if($car_data['body_style']=='Double Cab  Pickup'){
//         $car_data['body_style']="";
//     }
//     slecho("car that has stocknumber: {$car_data['stock_number']} and price:{$car_data['price']}");
//     if($car_data['price']==0){
//                 slecho("Excluding car that has: {$car_data['stock_number']}");
//                 return null;
//     }

//     return $car_data;
// }

add_filter("filter_for_aia_drydengm", "filter_for_aia_drydengm", 10, 1);

function filter_for_aia_drydengm($car)
{
    if ($car['price'] == "$0.00") {
        slecho("We are removing this car");
        $car = [];
    }

    return $car;
}

add_filter('filter_drydengm_car_data', 'filter_drydengm_car_data');

function filter_drydengm_car_data($car_data) {
   
    if($car_data['url'] == 'https://www.drydengm.ca/inventory/123456789') {
        $car_data = []; 
    }
    if(strlen($car_data['model'])>20){
        return null;
    }
    
    if($car_data['price']<=0){
        slecho("price $0 We are removing this car");
        return null;
    }

    return $car_data;
}
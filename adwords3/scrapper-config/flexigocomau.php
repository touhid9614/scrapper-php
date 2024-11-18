<?php
global $scrapper_configs;
$scrapper_configs["flexigocomau"] = array( 
    'entry_points'        => array(
        'new' => 'https://flexigo.com.au/car-subscriptions/',
    ),

    'vdp_url_regex'     => '/\/car-subscriptions/i',
    "use-proxy"           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://flexigo.com.au/yews_vehicles-sitemap.xml";
        $vdp_url_regex        = '/\/car-subscriptions/i';
        $images_regx          = '/data-orig-src="(?<img_url>[^"]+)"\s*alt\s*/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = true;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        // Modify car data if needed
        // $annoy_func = function ($car_data) {
        //     return $car_data;
        // };

        $data_capture_regx_full = [
            'stock_type'     => 'used', // Must scrap
            'year'           => '/model-year=(?<year>[^"]+)">SUB/i',
            'make'           => '/v_make=(?<make>[^\&]+)/i',
            'model'          => '/v_model=(?<model>[^\&]+)/i',
            'price'          => '/car_price=(?<price>[^\&]+)/i',
            'stock_number'   => '/stock_number=(?<stock_number>[^\&]+)/i',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);
// 	'entry_points' => array(
//             //'new'   => 'https://www.folsomlakevw.com/new-volkswagen-folsom-ca',
//             'used'  => 'https://flexigo.com.au/car-subscriptions/',
         
//         ),
//         'vdp_url_regex'     => '/\/car-subscriptions/i',
//      'refine'=>false,
//         'required_params'   => array('car_id'),
//         'use-proxy' => false,
//        'picture_selectors' => ['.fusion-lightbox'],
//         'picture_nexts' => [''],
//         'picture_prevs' => [''],
//         'details_start_tag' => '<div class="car-listings-archive',
//         'details_end_tag' => '<section class="fusion-tb-footer',
//         'details_spliter' => '<div class="car-listing cl-',
         
    
//         'data_capture_regx' => array(
//             'url'           => '/car-info-link" href="(?<url>[^"]+)"/',
//             'biweekly'      => '/From<[^\$]+[^>]+>(?<biweekly>[^<]+)/',
//             'price'         => '/class="clprice">(?<price>[^<]+)/',
//              'year'          => '/car-year">(?<year>[0-9,]+)/',
//             'make'          => '/car-make">(?<make>[^\<]+)/',
//             'model'         => '/car-model">(?<model>[^<]+)/',
//         ),
//         'data_capture_regx_full' => array(
            
          
//         ),
//             'next_page_regx'    => '/next page-numbers" href="(?<next>[^"]+)"/',
//           'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="fusion-lightbox"/',
          
//         );


// add_filter('filter_flexigocomau_field_url', 'filter_flexigocomau_field_url');

// function filter_flexigocomau_field_url($url) {
//     slecho("URL:" . $url);
//     $url = str_replace('\\', '', $url);
//     return $url;
// }

// add_filter('filter_flexigocomau_car_data', 'filter_flexigocomau_car_data');

// function filter_flexigocomau_car_data($car_data) {

     
//     if($car_data['stock_type']=='demo'){
//         $car_data['custom']="demo";
//         $car_data['stock_type']="new";
//     }
//     else{
//         $car_data['custom']=$car_data['stock_type'];
//     }
    
//     return $car_data;
// }

// add_filter("filter_flexigocomau_field_images", "filter_flexigocomau_field_images");

// function filter_flexigocomau_field_images($im_urls) {
//     return array_filter($im_urls, function($im_url) {
//         return !endsWith($im_url, 'coming-soon.jpg');
//     });
// }


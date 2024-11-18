<?php
global $scrapper_configs;
$scrapper_configs["mpmercurycom"] = array( 
    'entry_points'        => array(
        'new' => 'https://mpboatcentre.com/boats?condition=New',
    ),

    'vdp_url_regex'       => '/\/boat\//',
    "use-proxy"           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://mpboatcentre.com/sitemap.xml";
        $vdp_url_regex        = '/\/boat\//';
        $images_regx          = '/<img data-id="[^"]+"[^"]+"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = true;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        // Modify car data if needed

        $data_capture_regx_full = [
            'stock_type'     => '/https:\/\/mpboatcentre.com\/\/boat\/(?<stock_type>[^\_]+)/', // Must scrap
            'stock_number'  => '/STK Number:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'year' => '/Year:[^>]+>[^>]+>(?<year>[^<]+)/',
            'make' => '/Manufacturer:[^>]+>[^>]+>(?<make>[^<]+)/',
            'model' => '/<span>Model:[^>]+>[^>]+>(?<model>[^<]+)/',
            'price' => '/<li><span>\s*\$\s*(?<price>[^\s*]+)/',
            'body_style' => 'Boat',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);


//     'entry_points' => array(
//         //https://smedia-hq.slack.com/archives/C01QFVB637V/p1664989846378499
//          'used' => 'https://mpboatcentre.com/boats?condition=Pre-Owned',
//          'new'  => 'https://mpboatcentre.com/boats?condition=New',
//     ),
//     'use-proxy' => true,
//     'refine'    => false,
//     'vdp_url_regex' => '/\/boat\/-/i',
//     'picture_selectors' => ['.fancybox-image'],
//     'picture_nexts' => ['.owl-next'],
//     'picture_prevs' => ['.owl-prev'],
 
//     'details_start_tag' => 'class="navHead menuList">',
//     'details_end_tag'   => 'class="loader-wrapper"',
//     'details_spliter'   => 'class="col-lg-4">',
// 'data_capture_regx' => array(
//     'url' => '/href="(?<url>[^"]+)">\s*<div\s*class="boatCard">/',
// ),
// 'data_capture_regx_full' => array(
//     'stock_number'  => '/STK Number:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
//     'year' => '/Year:[^>]+>[^>]+>(?<year>[^<]+)/',
//     'make' => '/Manufacturer:[^>]+>[^>]+>(?<make>[^<]+)/',
//     'model' => '/<span>Model:[^>]+>[^>]+>(?<model>[^<]+)/',
//     'price' => '/<li><span>\s*\$\s*(?<price>[^\s*]+)/',
// //     'body_style' => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
// //     'exterior_color' => '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',     
// //     'url' => '/href="(?<url>[^"]+)">\s*<div\s*class="boatCard">/'
// //     //'vin'           => '/VIN[^\=]*[^\>]*\>(?<vin>[^\<]+)/',
// //     //'fuel_type'     => '/Fuel System[^>]*>[^>]*>(?<fuel_type>[^<]+)/',
// //     'engine'        => '/<dt>Engine Type[^>]*>[^>]*>(?<engine>[^<]+)/',
// //    // 'drivetrain'    => '/Engine Type[^>]*>[^>]*>(?<drivetrain>[^<]+)/',
// //     'description'   => '/<meta name="description" content="(?<description>[^\"]+)/',
// //     'kilometres'    => '/strong\>Usage[^=]*[^>]*\>(?<kilometres>[^\<]+)/',
// ),
// 'next_page_regx' => '/data-ajax_url="(?<next>[^"]+)/',
// 'images_regx' => '/<img data-id="[^"]+"[^"]+"(?<img_url>[^"]+)/',
// );

// add_filter('filter_mpmercurycom_car_data', 'filter_mpmercurycom_car_data');

// function filter_mpmercurycom_car_data($car_data) {

// $car_data['body_style'] ="Boat";

// return $car_data;
// }


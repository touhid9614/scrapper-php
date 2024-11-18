<?php

global $scrapper_configs;

$scrapper_configs["budgetcarsales"] = array(
    'entry_points'           => array(
        'used' => 'https://www.bcsautosales.ca/view-vehicles',
    ),

    'use-proxy'              => true,
    'refine'                 => false,
    'vdp_url_regex'          => '/\/vehicles\/[^\/]+\/[0-9]{4}-/i',
    'srp_page_regex'         => '/\/view-vehicles/i',

    'picture_selectors'      => ['#picture'],
    'picture_nexts'          => ['.right_triangle'],
    'picture_prevs'          => ['.left_triangle'],

    'details_start_tag'      => '<div class="single_col_body">',
    'details_end_tag'        => '<!-- /content_inventory -->',
    'details_spliter'        => 'class="but_carproof_search_logo">',

    'data_capture_regx'      => array(
        'url'          => '/class="make">(?<year>[0-9]{4})[^>]+>\s*<a href="(?<url>[^"]+)" class="model" title="View Details[^>]+>(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'year'         => '/class="make">(?<year>[0-9]{4})[^>]+>\s*<a href="(?<url>[^"]+)" class="model" title="View Details[^>]+>(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'make'         => '/class="make">(?<year>[0-9]{4})[^>]+>\s*<a href="(?<url>[^"]+)" class="model" title="View Details[^>]+>(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model'        => '/class="make">(?<year>[0-9]{4})[^>]+>\s*<a href="(?<url>[^"]+)" class="model" title="View Details[^>]+>(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'stock_number' => '/Stock Number:<\/span>\s*(?<stock_number>[^<]+)/',
        'price'        => '/<p class="price_regular">(?<price>\$[0-9,]+)/',
        'vin'          => '/Stock Number:<\/span>\s*(?<vin>[^<]+)/',
        'kilometres'   => '/Odometer:<\/span>\s*(?<kilometres>[^\s]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style'     => '/Body Style<\/strong><\/p><\/div>[^>]+><p>(?<body_style>[^<]+)/',
        'engine'         => '/Engine<\/strong><\/p><\/div>[^>]+><p>(?<engine>[^<]+)/',
        'transmission'   => '/Transmission<\/strong><\/p><\/div>[^>]+><p>(?<transmission>[^<]+)/',
        'drivetrain'     => '/Drive Train<\/strong><\/p><\/div>[^>]+><p>(?<drivetrain>[^<]+)/',
        'exterior_color' => '/Exterior Color<\/strong><\/p><\/div>[^>]+><p>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color<\/strong><\/p><\/div>[^>]+><p>(?<interior_color>[^<]+)/',
        'description'    => '/<h2 style="font-style[^>]+>[^>]+>\s*<p>(?<description>[^<]+)/',
    ),
    'next_page_regx'         => '/<a href="(?<next>[^"]+)" class="button_next item"> Next/',
    'images_regx'            => '/<span id="picture_[^>]+><img src="(?<img_url>[^"]+)"/',
);
add_filter("filter_budgetcarsales_field_images", "filter_budgetcarsales_field_images");

function filter_budgetcarsales_field_images($im_urls)
    {
        $retval = [];
        
        foreach($im_urls as $img)
        {
            $retval[] = $img . "?w=650";
        }
        
        return $retval;
    }

    add_filter('filter_budgetcarsales_car_data', 'filter_budgetcarsales_car_data');



function filter_budgetcarsales_car_data($car_data) {
   

    if($car_data['stock_number']=='221409'){
        $car_data['model'] = strtolower($car_data['model']);
        $car_data['model'] = ucfirst($car_data['model']);
    }



    return $car_data;
}



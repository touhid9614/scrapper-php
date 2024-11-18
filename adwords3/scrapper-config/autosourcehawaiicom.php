<?php
global $scrapper_configs;
$scrapper_configs["autosourcehawaiicom"] = array( 

   'entry_points' => array(
            'used' => 'https://www.autosourcehawaii.com/inventory/?pg=1',       
        ),
        'vdp_url_regex'     => '/\/view\//i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        
        'use-proxy' => true,
     'refine'=>false,
       'picture_selectors'   => ['.modal_small_pic'],
       'picture_nexts'       => ['..fancybox-button--arrow_right'],
       'picture_prevs'       => ['..fancybox-button--arrow_left'],
        
        'details_start_tag' => '<div class="search_result_wrapper',
        'details_end_tag'   => '<div class="footer-',
        'details_spliter'   => '<li class="vehicle-item',
        'data_capture_regx' => array(
            'url'           => '/title_price">\s*<a href="(?<url>[^"]+)">/',
            'year'          => '/title_holder desc_l5">\s*[^>]+>\s*(?<year>[^\s*<]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
            'make'          => '/title_holder desc_l5">\s*[^>]+>\s*(?<year>[^\s*<]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
            'model'         => '/title_holder desc_l5">\s*[^>]+>\s*(?<year>[^\s*<]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
            'price'         => '/class="price">(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Miles :\s*[^>]+>[^>]+>(?<kilometres>[^\<]+)/',
            'transmission'  => '/Transmission :\s*[^>]+>(?<transmission>[^\<]+)/',
            'vin'     => '/Vin :\s*[^>]+>[^>]+>(?<vin>[^\<]+)/',

            'stock_number' => '/Inventory ID\s*:\s*[^>]+>\s*[^>]+>\s*(?<stock_number>[^<]+)/',

        ),
        'data_capture_regx_full' => array(        
           'stock_type'     => '/<meta name="vehicle_state" content="(?<stock_type>[^"<]+)/i',  
            'exterior_color' => '/<meta name="vehicle_exterior_color" content="(?<exterior_color>[^"]+)/i', 
           'body_style'     => '/<meta name="vehicle_body_style" content="(?<body_style>[^"<]+)/i',
           'stock_number' => '/Stock:\s*(?<stock_number>[^<]+)/',
        ) ,
        'next_page_regx'    => '/active">[^>]+>[^>]+>[^>]+>[^>]+><a href="(?<next>[^"]+)/',
        'images_regx'       => '/<a data-fancybox="gallery" href="(?<img_url>[^"]+)"/'
    );

add_filter('filter_autosourcehawaiicom_car_data', 'filter_autosourcehawaiicom_car_data');

function filter_autosourcehawaiicom_car_data($car_data) {
  
    
    $car_data['stock_type'] = strtolower($car_data['stock_type']);
   
    return $car_data;
}

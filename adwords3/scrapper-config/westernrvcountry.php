<?php
global $scrapper_configs;
 $scrapper_configs["westernrvcountry"] = array( 
	  'entry_points' => array(
            'used'  => 'https://www.westernrvcountry.com/used-rvs-for-sale?pagesize=100&page=1',
            'new'   => 'https://www.westernrvcountry.com/new-rvs-for-sale?pagesize=100&page=1', 
        ),
        'vdp_url_regex'     => '/\/product\/(?:new|used)-/i',
        'ty_url_regex'      => '/\/contact-confirmation/i',
        'use-proxy'         => true,
        'refine'            => false,
     
         'picture_selectors' => ['.cycle-slide a img'],
        'picture_nexts'     => ['.sliderNext'],
        'picture_prevs'     => ['.sliderPrev'],
     
        'details_start_tag' => '<div class="listingPagination listingToolbar">',
        'details_end_tag'   => '<div class="listingPagination bottomPaging',
        'details_spliter'   => "<li class='unit",
        'data_capture_regx' => array(
            'stock_number'      => '/data-stocknumber="(?<stock_number>[^"]+)/',
            'url'               => '/data-unitlink="(?<url>[^"]+)/',
            'year'              => '/data-year="(?<year>[^"]+)/',
            'make'              => '/data-brand="(?<make>[^"]+)/',
            'model'             => '/data-unitname="(?<model>[^"]+)/',
            'body_style'        => '/data-type="(?<body_style>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
            'price'             => '/Price:[^>]+>[^>]+>(?<price>[^<]+)/',
        ),
        'next_query_regx'   => '/<a href="#" class="next" title="Next Page" data-(?<param>page)="(?<value>[0-9]*)"/',
        'images_regx'       => '/<a title="Click to enlarge" href="(?<img_url>[^"]+)"/'
    );
// add_filter('filter_westernrvcountry_car_data', 'filter_westernrvcountry_car_data');

// function filter_westernrvcountry_car_data($car_data) {

//     if($car_data['price']="$0.00"){
//         $car_data['price']="Please Call";
//     }

//     return $car_data;
// }


    
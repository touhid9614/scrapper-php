<?php
global $scrapper_configs;
 $scrapper_configs["harveyrvscom"] = array( 
      'entry_points' => array(
          'rv'  => array(
                'https://www.harveyrvandmarine.com/used-rvs-for-sale?page=1&pagesize=12',
                'https://www.harveyrvandmarine.com/new-rvs-for-sale?page=1&pagesize=12', 
            ),
           'special'   => array(
                'https://www.harveyrvandmarine.com/rv-specials?page=1&pagesize=12',
                'https://www.harveyrvandmarine.com/boat-specials?page=1&pagesize=12',
            ),
            
            'boat'   => array(
                'https://www.harveyrvandmarine.com/new-boats-for-sale?page=1&pagesize=12',
                'https://www.harveyrvandmarine.com/used-boats-for-sale?page=1&pagesize=12',
            ),
        ),
        'vdp_url_regex'     => '/\/product\/(?:new|used)-/i',
        'srp_page_regex'          => '/\/(?:new|used)-rvs/i',
        'use-proxy'         => true,
        'refine'            => false,
        'details_start_tag' => '<div class="listingPagination listingToolbar">',
        'details_end_tag'   => '<div class="listingPagination bottomPaging',
       'details_spliter'   => "<li class='unit",
     //'details_spliter'   => "View Details",
        'data_capture_regx' => array(
            'stock_number'      => '/data-stocknumber="(?<stock_number>[^"]+)/',
            'url'               => '/data-unitlink="(?<url>[^"]+)/',
            'year'              => '/data-year="(?<year>[^"]+)/',
            'make'              => '/data-brand="(?<make>[^"]+)/',
            'model'             => '/data-unitname="(?<model>[^"]+)/',
            'custom'            => '/data-type="(?<custom>[^"]+)/',
            'body_style'        => '/data-type="(?<body_style>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
            'price'             => '/data-saleprice="(?<price>[^"]+)/',
            'msrp'              => '/(?:List Price|MSRP):[^>]+>[^>]+>(?<msrp>[^<]+)/',
            'vin'               => '/VIN<\/td>\s*[^>]+>\s*(?<vin>[^<]+)/',
        ),
        'next_query_regx'   => '/<a href="#" class="next" title="Next Page" data-(?<param>page)="(?<value>[0-9]*)"/',
        'images_regx'       => '/<li>\s*<img llsrc="(?<img_url>[^"]+)"/'
    );
 
add_filter('filter_harveyrvscom_car_data', 'filter_harveyrvscom_car_data');

function filter_harveyrvscom_car_data($car_data) {
    // $car_data['body_style'] = "Other";
    //making a feed for some body styles.
    $body_styles = [
        'Expandable',
        'Fifth Wheel',
        'Folding Pop-Up Camper',
        'Motor Home Class A',
        'Motor Home Class A - Diesel',
        'Toy Hauler Fifth Wheel',
        'Toy Hauler Travel Trailer',
        'Travel Trailer',
        'Truck Camper',
    ];

    if (in_array($car_data['custom'], $body_styles)) 
    {
        $car_data['custom'] = 1;
    }
    // else{
    //     $car_data['custom'] = 0;
    // }

    if ($car_data['stock_type'] == 'special') {
        // $car_data['custom'] = "special";
        $car_data['stock_type'] = "new";
    } 
    else if ($car_data['stock_type'] == 'rv') {
        // $car_data['body_style'] = "rv";
        if (strpos($car_data['url'], "new")) {
            $car_data['stock_type'] = "new";
        } else {
            $car_data['stock_type'] = "used";
        }
        // $car_data['custom'] = $car_data['stock_type'];
    } 
    else if ($car_data['stock_type'] == 'boat') {
        // $car_data['body_style'] = "boat";
        if (strpos($car_data['url'], "new")) {
            $car_data['stock_type'] = "new";
        } else {
            $car_data['stock_type'] = "used";
            $car_data['custom'] = 4;
        }
        // $car_data['custom'] = $car_data['stock_type'];
    }
    slecho("boddddy style: " . $car_data['body_style']);
    slecho("stock type: " . $car_data['stock_type']);
    slecho("custom: " . $car_data['custom']);

    // if($car_data['price'] == 0 || $car_data['price'] == "0" || $car_data['price'] == "$0.00"){
    //     $car_data['price'] = $car_data['msrp'];
    // }

    return $car_data;
}


add_filter('filter_for_fb_harveyrvscom', 'filter_for_fb_harveyrvscom', 10, 2);

function filter_for_fb_harveyrvscom($car_data, $feed_type)
{   
   
    if($car_data['price']<=0){
        $car_data['price']=$car_data['msrp'];
        
    }

    return $car_data;
}

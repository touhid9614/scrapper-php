<?php
global $scrapper_configs;
$scrapper_configs["liatoyotaofcoloniecom"] = array( 
	  'entry_points' => array(
            'used'  => 'https://www.liatoyotaofcolonie.com/searchused.aspx',
            'new'   => 'https://www.liatoyotaofcolonie.com/searchnew.aspx?Dealership=Lia%20Toyota%20of%20Colonie',
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/(?:new|used)-[^-]+-[0-9]{4}/i',
        'ty_url_regex'      => '/\/thankyou.aspx/i',
        'picture_selectors' => ['.carousel__item'],
        'refine'   => false,
        'picture_nexts'     => ['.carousel__control--next'],
        'picture_prevs'     => ['.carousel__control--prev'],
        'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div id="srpRow',
        'data_capture_regx' => array(
            'vin'           => '/VIN #:\s*<\/strong>[^>]+>(?<vin>[^<]+)/',
            'stock_number'  => '/Stock\s*#:\s*<\/strong>\s*(?<stock_number>[^<]+)/',
            // 'title'         => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            // 'year'          => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            // 'make'          => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            // 'model'         => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            'price'         => '/Price:\s* <i class="fa fa-question-circle">[^>]+>[^>]+>[^>]+>\s*[^>]+>(?<price>[$0-9,]+)/',
            'engine'        => '/Engine: <\/strong>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:\s*<\/strong>\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:\s*<\/strong>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. Color:\s*<\/strong>\s*(?<interior_color>[^<]+)/',
            'url'           => '/rel="(?<url>[^"]+)">/',
            'price'         => '/Our Price[^"]+"[^"]+"[^"]+"pull-right\s*primaryPrice">(?<price>[^<]+)/',
            //inside custom I am scraping discount value
            'custom'        => '/(?:YOU SAVE|LIA Discount):[^>]+>[^>]+>\-(?<custom>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'make'          => '/vehicleMake="(?<make>[^"]+)/',
            'model'         => '/vehicleModel="(?<model>[^"]+)/',
            'year'          => '/vehicleYear="(?<year>[^"]+)/',
            'trim'          => '/vehicleTrim="(?<trim>[^"]+)/',
            'price'         => '/"msrp":\s*"(?<price>[^"]+)/',
            'body_style'    => '/Body Style:\s*<\/strong>\s*(?<body_style>[^<]+)/',
            'kilometres'    => '/Mileage:\s*<\/strong>\s*(?<kilometres>[^<]+)/',
        ) ,
        'next_page_regx'    => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
        'images_regx'       => '/data-image-full="(?<img_url>[^"]+)"/',
    );

add_filter('filter_liatoyotaofcoloniecom_car_data', 'filter_liatoyotaofcoloniecom_car_data');

function filter_liatoyotaofcoloniecom_car_data($car_data) {
    if($car_data['custom'] != NULL){
        $car_data['custom'] = $car_data['custom'];
    }
    else{
        $car_data['custom'] = "$0";
    }
    return $car_data;
}
    
    
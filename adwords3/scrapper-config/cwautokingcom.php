<?php
global $scrapper_configs;
$scrapper_configs["cwautokingcom"] = array( 
	 'entry_points' => array(
            'used'  => 'http://cwautoking.com/home/inventory/',
        ),
        'vdp_url_regex'     => '/home\/inventory\//i',
        
        'use-proxy' => true,
        'picture_selectors' => ['..attachment-thumbnail'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<div class="col-sm-9',
        'details_end_tag'   => '<div class="container-fluid footer">',
        'details_spliter'   => '<div class="result-car',
        
        'data_capture_regx' => array(
            'url'           => '/<a class="result-car-link" href="(?<url>[^"]+)"/',
            'year'          => '/class="mini-hide">(?<year>[0-9]{4})/',
            'make'          => '/class="mini-hide">(?<year>[0-9]{4})[^>]+>\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/',
            'model'         => '/class="mini-hide">(?<year>[0-9]{4})[^>]+>\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/',    
            'price'         => '/class="price-style[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/class="miles-style">(?<kilometres>[^\s*]+)/',
            'stock_number'  => '/Stock\s*#\s*:\s*(?<stock_number>[^<]+)/',
            'vin'           => '/Stock\s*#\s*:\s*(?<vin>[^<]+)/',
            'fuel_type'      => '/Fuel Type:[^>]+>(?<fuel_type>[^<]+)/',
         ),
        'data_capture_regx_full' => array(
            
            'exterior_color'=> '/Exterior:[^>]+>\s*(?<exterior_color>[^<]+)/',
           // 'engine'        => '/Engine Size<\/dt>\s*<dd[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>\s*(?<transmission>[^<]+)/',
            'interior_color'=> '/Interior:[^>]+>\s*(?<interior_color>[^<]+)/',
           // 'body_style'    => '/Body Style<\/dt>\s*<dd[^>]*>(?<body_style>[^<]+)/',
            'description' => '/<meta property="og:description" content="(?<description>[^"]+)/'
        ),
        //'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a class="item" href="(?<img_url>[^"]+)">[^>]+>[^>]+><img width="640"/'
    );
   add_filter("filter_cwautokingcom_field_description", "filter_cwautokingcom_field_description");

function filter_cwautokingcom_field_description($description) {
    return strip_tags($description);
}

<?php
global $scrapper_configs;
$scrapper_configs["flexibuycomau"] = array( 
	"entry_points" => array(
             'used'  => 'https://flexibuy.com.au/vehicles/',
	        //'new'   => 'https://crickshighwaysubaru.com.au/stock/new',
         ),
        'vdp_url_regex'     => '/au\/rent-to-own-cars\//i',
        'use-proxy' => true,
        'refine'=>false,
        'details_start_tag' => '<div class="car-listings listing-columns">',
        'details_end_tag'   => '<!-- car-listings listing-columns -->',
        'details_spliter'   => '<div class="car-listing',
        'data_capture_regx' => array(
            'url'                 => '/class="car-info-btn"\s*href="(?<url>[^"]+)"/',
            
        ),
        'data_capture_regx_full' => array( 
            'year'                => '/Year<\/p>\s*<\/div>[^>]+><p>(?<year>[0-9]{4}+)/',
            'make'                => '/Make<\/p>\s*<\/div>[^>]+><p>(?<make>[^<]+)/',
            'model'               => '/Model<\/p>\s*<\/div>[^>]+><p>(?<model>[^ <]+)/',
            'price'               => '/">(?<price>\$[0-9,.]+)\s*p\/wk/',
            'trim'                => '/<h1 class="entry-title">(?<make>[^ "]+)\s*(?<model>[^ "]+)\s*(?<trim>[^&]+)/',
            //'stock_number'        => '/class="stock_nos" value="(?<stock_number>[^"]+)/',
            'transmission'        => '/Transmission<\/p>\s*<\/div>[^>]+><p>(?<transmission>[^<]+)/',
            'kilometres'          => '/Odometer<\/p>\s*<\/div>[^>]+><p>(?<kilometres>[^<]+)/',
            'exterior_color'      => '/Body Colour<\/p>\s*<\/div>[^>]+><p>(?<exterior_color>[^<]+)/',    
//            'engine'              => '/Engine:<\/b>\s*<span>(?<engine>[^\<]+)/',  
//            'vin'              => '/VIN:<\/b>\s*<span>(?<vin>[^\<]+)/',       
//            'description'         => '/<h2>Comments<\/h2>\s*<p>(?<description>[\s\S]*?(?=<h2>))/',
        ) ,
       //'next_page_regx'    => '/<a href="(?<next>[^"]+)" rel="next"\s*class="btn btn-primary"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="fusion-lightbox"/',
    );
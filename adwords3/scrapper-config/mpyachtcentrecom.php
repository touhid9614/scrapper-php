<?php
global $scrapper_configs;
$scrapper_configs["mpyachtcentrecom"] = array( 
	 'entry_points' => array(
            //https://smedia-hq.slack.com/archives/C01QFVB637V/p1664989846378499
	         'used' => 'https://www.mpyachtcentre.com/boats?condition=Pre-Owned&load_more=1&current_page=1',
             'new'  => array( 
                        'https://www.mpyachtcentre.com/boats?condition=New&load_more=1&current_page=1',
                        'https://www.mpyachtcentre.com/boats?condition=New&load_more=1&current_page=2',
                        'https://www.mpyachtcentre.com/boats?condition=New&load_more=1&current_page=3',
                 ),
        ),
        'use-proxy' => true,
        'refine'    => false,
        'srp_page_regex'      => '/\/boats\?condition=(?:Pre-Owned|New)/i',
        'vdp_url_regex' => '/\/boat\/(?:new|used)_[0-9]{4}/i',
     //   'vdp_url_regex' => '/\/boat\//i',
        'picture_selectors' => ['.fancybox-image'],
        'picture_nexts' => ['.owl-next'],
        'picture_prevs' => ['.owl-prev'],
     
        //'details_start_tag' => 'class="navHead menuList">',
        //'details_end_tag'   => 'class="loader-wrapper"',
        'details_spliter'   => '"col-lg-4',
    'data_capture_regx' => array(
        'url' => '/<a href=[^"]+"(?<url>[^\\\]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number'  => '/STK Number:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'year' => '/Year:[^>]+>[^>]+>(?<year>[^<]+)/',
        'make' => '/Manufacturer:[^>]+>[^>]+>(?<make>[^<]+)/',
        'model' => '/<span>Model:[^>]+>[^>]+>(?<model>[^<]+)/',
        'price' => '/<li><span>\s*\$\s*(?<price>[^\s*]+)/',
    //     'body_style' => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
    //     'exterior_color' => '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',     
    //     'url' => '/href="(?<url>[^"]+)">\s*<div\s*class="boatCard">/'
    //     //'vin'           => '/VIN[^\=]*[^\>]*\>(?<vin>[^\<]+)/',
    //     //'fuel_type'     => '/Fuel System[^>]*>[^>]*>(?<fuel_type>[^<]+)/',
    //     'engine'        => '/<dt>Engine Type[^>]*>[^>]*>(?<engine>[^<]+)/',
    //    // 'drivetrain'    => '/Engine Type[^>]*>[^>]*>(?<drivetrain>[^<]+)/',
    //     'description'   => '/<meta name="description" content="(?<description>[^\"]+)/',
    //     'kilometres'    => '/strong\>Usage[^=]*[^>]*\>(?<kilometres>[^\<]+)/',
    ),
    'next_page_regx' => '/data-ajax_url="(?<next>[^"]+)/',
    'images_regx' => '/<img data-id="[^"]+"[^"]+"(?<img_url>[^"]+)/',
);

add_filter('filter_mpyachtcentrecom_car_data', 'filter_mpyachtcentrecom_car_data');

function filter_mpyachtcentrecom_car_data($car_data) {
  
    $car_data['body_style'] ="Other";
    
    if(strpos($car_data['all_images'],"default") )
    {
        $car_data['all_images']="";
    }
    
    return $car_data;
}

<?php
global $scrapper_configs;
$scrapper_configs["mpboatcentrecom"] = array( 
	 'entry_points' => array(
            //https://smedia-hq.slack.com/archives/C01QFVB637V/p1664989846378499
	         'used' => 'https://www.mpboatcentre.com/boats?condition=Pre-Owned&load_more=1&current_page=1',
             'new'  => array( 
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=1',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=2',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=3',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=4',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=5',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=6',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=7',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=8',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=9',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=10',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=11',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=12',
                        'https://www.mpboatcentre.com/boats?condition=New&load_more=1&current_page=13',
                 ),
        ),
        'use-proxy' => true,
        'refine'    => false,
        'srp_page_regex'      => '/\/boats\?condition=(?:Pre-Owned|New)/i',
        'vdp_url_regex' => '/\/boat\/(?:new|used)_[0-9]{4}/i',
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

add_filter('filter_mpboatcentrecom_car_data', 'filter_mpboatcentrecom_car_data');

function filter_mpboatcentrecom_car_data($car_data) {
  
    $car_data['body_style'] ="Other";
    $acceptted_data=[
        'Tigé',
        'Tige',
        'Heyday',
        'Boston whaler',
        'Robalo',
        'Rh aluminum boats',
        'Bayliner',
        'Atx surf boats',
    ];
    
    if (in_array($car_data['make'], $acceptted_data)) 
    {
        slecho("included car that has  ,{$car_data['make']}");
        $car_data['model']=preg_replace('/[^A-Za-z0-9 ]/', '', $car_data['model']);   
        $car_data['model']=ucwords(strtolower($car_data['model']));   
         return $car_data;

    }
  
    
    return null;
}


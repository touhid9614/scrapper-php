<?php
global $scrapper_configs;
$scrapper_configs["westernplainsautomotivecomau"] = array( 
    'entry_points' => array(
        'new'  => 'https://www.westernplainsautomotive.com.au/stock?condition=New',
        'used' => 'https://www.westernplainsautomotive.com.au/stock?condition=Used',
        'demo' => 'https://www.westernplainsautomotive.com.au/stock?condition=Demo',
    ),
    'vdp_url_regex'  => '/\.au\/stock\/details\//i', 
    'srp_page_regex' => '/\/stock\?condition/',
    'refine'         => false,     
    'use-proxy'      => true,

    'details_start_tag' => 'class="top-header">',
    'details_end_tag' => 'class="footer"',
    'details_spliter' => 'class="stock-item c-',
    'data_capture_regx' => array(
        'url'           => '/class="embla__container">\s*<div class="embla__slide"><a href="(?<url>[^"]+)"\s*tab/',
        'stock_number'  => '/data-stockno="(?<stock_number>[^"]+)/',
        'vin'           => '/data-vin="(?<vin>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        'year'          => '/class="year">(?<year>[^<]+)/',
        'make'          => '/class="make">(?<make>[^<]+)/',
        'model'         => '/class="model">(?<model>[^<]+)/',
        'price'         => '/\'price\':(?<price>[^\,]+)/',
        'body_style'    => '/\'body\':\s*\'(?<body_style>[^\,]+)\'/',
    ),
    //'next_query_regx' => '/dxp-num dxp-current">[^<]+<\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl01\$ctl00\$ASPxPager(?:1|2)&#39;,+&#39;(?<param>PN)(?<value>[0-9]+)+/',
    'images_regx' => '/\'image\':\s*\'(?<img_url>[^\']+)/'

);

add_filter('filter_westernplainsautomotivecomau_car_data', 'filter_westernplainsautomotivecomau_car_data');

function filter_westernplainsautomotivecomau_car_data($car_data)
{                     
    if($car_data['stock_type']=='demo'){
        $car_data['custom_1']="demo";
        $car_data['custom']="demo";
        $car_data['stock_type']="new";
    }
    else{
        $car_data['custom_1']=$car_data['stock_type'];
        $car_data['custom']=$car_data['stock_type'];
    }
    $car_data['stock_type']=strtolower($car_data['stock_type']);
    $car_data['custom']=strtolower($car_data['custom']);
    return $car_data;
}
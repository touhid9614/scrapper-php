<?php
global $scrapper_configs;
$scrapper_configs["jerryscarsales"] = array(
    "entry_points" => array(
        'used' => 'https://jerryscarsales.com/cars/',
    ),

    'vdp_url_regex' => '/\/cars\//i',
    'use-proxy' => true,

    'picture_selectors' => [' div.a3dg-nav > div.a3dg-thumbs.a3dg-thumbs-static > ul > li'],
    'picture_nexts' => ['div.a3dg-image-wrapper > div.fa.fa-caret-right.a3dg-next'],
    'picture_prevs' => ['div.a3dg-image-wrapper > div.fa.fa-caret-left.a3dg-prev'],

    'details_start_tag' => '<div id="primary" class="content-area">',
    'details_end_tag' => '<div class="_addfilter bg-red">',
    'details_spliter' => '</div></li>',

    'data_capture_regx' => array(
        'url' => '/class="slider-add"><[^"]+"(?<url>[^"]+)/',
        'title' => '/class="woocommerce-loop[^"]+">(?<title>[^<]+)/',
        'year' => '/<ul class="v_type">[^<].*<li>(?<year>[^<]+)<\/li>[^<].*<li>(?<exterior_color>[^<]+)<\/li>[^<]\s.*<li>(?<kilometres>[^<]+)/',
        'make' => '/class="woocommerce-loop[^"]+">(?<make>[^\s]+)\s(?<model>[^<]+)/',
        'model' => '/class="woocommerce-loop[^"]+">(?<make>[^\s]+)\s(?<model>[^<]+)/',
        'kilometres' => '/<ul class="v_type">[^<].*<li>(?<year>[^<]+)<\/li>[^<].*<li>(?<exterior_color>[^<]+)<\/li>[^<]\s.*<li>(?<kilometres>[^<]+)/',
        'exterior_color' => '/<ul class="v_type">[^<].*<li>(?<year>[^<]+)<\/li>[^<].*<li>(?<exterior_color>[^<]+)<\/li>[^<]\s.*<li>(?<kilometres>[^<]+)/',
        'price' => '/<span class="woocommerce-Price-currencySymbol">&#36;<\/span>(?<price>[^<]+)/',
        ),

    'data_capture_regx_full' => array(
        'price' => '/<p class="price">.*class="woocommerce-Price-currencySymbol">[^<]+<\/span>(?<price>[^<]+)/',
        'body_style' => '/Type<\/td><td>[^>]+>[^>]+>(?<body_style>[^<]+)/',
        'transmission'  => '/Transmission<\/td><td>(?<transmission>[^<]+)/',
        'drivetrain'    => '/Transmission<\/td><td>(?<drivetrain>[^<]+)/',
        'engine'        => '/Motor<\/td><td>(?<engine>[^<]+)/',
        'description'   => '/<p><strong>(?<description>[^<]+)/',
    ),

    'next_page_regx' => '/<a class="next.*href="(?<next>[^"]+)/',
    'images_regx' => '/title="" rel.*href="(?<img_url>[^"]+)/',
);

add_filter('filter_jerryscarsales_car_data', 'filter_jerryscarsales_car_data');

function filter_jerryscarsales_car_data($car_data) {
    
    $car_data['vin'] = substr($car_data['stock_number'], 0,17);
  
    return $car_data;
}

<?php

global $scrapper_configs;

$scrapper_configs['westernautoimports'] = array(
    'entry_points' => array(
        'used' => 'https://www.westernautoimports.ca/inventory/?condition=used'
    ),
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next', '.fancybox-next'],
    'picture_prevs' => ['.owl-prev', '.fancybox-prev'],
    'details_start_tag' => '<div id="listings-result">',
    'details_end_tag' => '<footer',
    'details_spliter' => 'class="col-md-4 col-sm-4 col-xs-12 col-xxs-12',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)" class="rmv_txt_drctn">/',
        'title' => '/<div class="car-title"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'year' => '/<div class="car-title"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'make' => '/<div class="car-title"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'model' => '/<div class="car-title"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'price' => '/class="sale-price">\s*(?<price>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
        'kilometres'   => '/Odometer<\/td>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number' => '/stock\s*# <\/span>(?<stock_number>[^<]+)/',
        'transmission' => '/Transmission<\/td>[^>]+>(?<transmission>[^<]+)/',
        'vin'          => '/Vin<\/td>[^>]+>(?<vin>[^<]+)/',
        'drivetrain'   => '/Drivetrain<\/td>[^>]+>(?<drivetrain>[^<]+)/',
        'fuel_type'    => '/Fuel Type<\/td>[^>]+>(?<fuel_type>[^<]+)/',
    ),
    'next_page_regx' => '/class="next page-numbers" href="(?<next>[^"]+)/',
    'images_regx' => '/<a href="(?<img_url>[^"]+)" class="stm_fancybox"/',
);
add_filter("filter_westernautoimports_field_price", "filter_westernautoimports_field_price", 10, 3);

function filter_westernautoimports_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Final Price: $price");
    }


    $msrp_regex = '/regular-price">\s*<span[^\n]+\s*(?<price>\$[0-9,\s]+)/';
    $normal_regex = '/sale-price">\s*<span[^>]+>(?<price>\$[0-9,\s]+)/';
    $regular_regex = '/normal-price">\s*<span[^\n]+\s*(?<price>\$[0-9,\s]+)/';



    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($normal_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex price: {$matches['price']}");
    }

    if (preg_match($regular_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex price: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

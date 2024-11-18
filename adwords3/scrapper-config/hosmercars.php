<?php

global $scrapper_configs;
$scrapper_configs["hosmercars"] = array(
    'entry_points' => array(
        'new' => 'https://www.hosmercars.com/new-vehicles-for-sale',
        'used' => 'https://www.hosmercars.com/used-vehicles-for-sale'
    ),
    'vdp_url_regex' => '/\/(?:New|Used)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.vehicleDetailImage',],
    'picture_nexts' => ['span.ps-nextIcon'],
    'picture_prevs' => ['span.ps-prevIcon'],
    'details_start_tag' => '<div class="globalMarginSpacing">',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div id="vehicleRow"',
    'data_capture_regx' => array(
        'url' => '/<a class="font-weight-bold"\s*href="(?<url>[^"]+)">\s*(?<title>.*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'stock_number' => '/Stock\s*#:<\/span>[^<]+<span[^>]+>\s*(?<stock_number>[^\s*]+)/',
        'title' => '/<a class="font-weight-bold"\s*href="(?<url>[^"]+)">\s*(?<title>.*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'year' => '/<a class="font-weight-bold"\s*href="(?<url>[^"]+)">\s*(?<title>.*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make' => '/<a class="font-weight-bold"\s*href="(?<url>[^"]+)">\s*(?<title>.*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/<a class="font-weight-bold"\s*href="(?<url>[^"]+)">\s*(?<title>.*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'price' => '/Our Price is Only:\s*<\/div>\s*<div\s*[^>]+>(?<price>[^<]+)/',
        'engine' => '/Engine:<\/span><span[^>]+>\s*(?<engine>[^,]+)/',
        'transmission' => '/Transmission:<\/span><span[^>]+>\s*(?<transmission>[^\,]+)/',
    ),
    'data_capture_regx_full' => array(
        // 'body_style' => '/itemprop="driveWheelConfiguration">\s*(?<body_style>[^\n]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer">\s*(?<kilometres>[^\s*]+)/',
        'exterior_color' => '/itemprop="color">\s*(?<exterior_color>[^\s*]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">\s*(?<interior_color>[^\s*]+)/',
    ),
    'next_page_regx' => '/href=\'(?<next>[^\']+)\'>Next Page/',
    'images_regx' => '/<img class="img-responsive vehicleDetailBaseImage" src="(?<img_url>[^"]+)/',
);

add_filter("filter_hosmercars_field_price", "filter_hosmercars_field_price", 10, 3);

function filter_hosmercars_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Sale Price:[^;]+;(?<price>[^<]+)/';

    $internet_regex = '/<div class="searchVehiclePriceUsed">(?<price>[^<]+)/';



    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }


    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

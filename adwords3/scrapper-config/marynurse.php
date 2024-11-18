<?php

global $scrapper_configs;
$scrapper_configs["marynurse"] = array(
    'entry_points' => array(
        'used' => 'https://www.marynurse.com/used/',
        'new' => 'https://www.marynurse.com/new/'
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon-chevron-left'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<div class="ajax-loading"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        // 'stock_type' => '/"condition":"(?<stock_type>[^"]+)/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate>(?<model>[^\<]+)/',
        'trim' => '/"trim":"(?<trim>[^"]+)"/',
        'price' => '/Cash Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'vin'       => '/VIN:[^>]+>[^>]+>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/<img onerror="imgError\(this\)\;" (?:data-src|src)="(?<img_url>[^"]+)/'
);

add_filter("filter_marynurse_field_price", "filter_marynurse_field_price", 10, 3);

function filter_marynurse_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $internet_regex = '/Price:<\/span>\s*<span[^>]+><meta[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';

    $matches = [];

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
// add_filter('filter_marynurse_car_data', 'filter_marynurse_car_data');

// function filter_marynurse_car_data($car_data) {

//     $car_data['stock_type'] = strtolower($car_data['stock_type']);
    
//     return $car_data;
// }
add_filter("filter_marynurse_field_images", "filter_marynurse_field_images");
function filter_marynurse_field_images($im_urls) {
    if (count($im_urls) < 3) {
        return array();
    }
    return $im_urls;
}
 

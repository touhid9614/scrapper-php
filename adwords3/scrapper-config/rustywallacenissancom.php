<?php

global $scrapper_configs;

$scrapper_configs['rustywallacenissancom'] = array(
    'entry_points' => array(
        'new' => 'https://www.rustywallacenissan.com/new-vehicles-knoxville-tn?expanded%5B%5D=finalPrice&limit=500',
        'used' => 'https://www.rustywallacenissan.com/used-vehicles-knoxville-tn?expanded%5B%5D=mileage&limit=500',
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<div class="module-container js-module mod-inventory-listing',
    'details_end_tag' => '<footer class="no-print"',
    'details_spliter' => '<div class="inventory-item  clearfix',
    'data_capture_regx' => array(
        'stock_number' => '/Stock:\s*(?<stock_number>[^<]+)/',
        'url' => '/<a href="(?<url>[^"]+)"\s*class="vehicle-title ">/',
        'title' => '/class="vehicle-title ">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'year' => '/class="vehicle-title ">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'make' => '/class="vehicle-title ">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'model' => '/class="vehicle-title ">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'price' => '/Our Price\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
        'exterior_color' => '/Exterior Color:\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:\s*(?<interior_color>[^<]+)/',
        'engine' => '/Engine:\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission Description:\s*(?<transmission>[^<]+)/',
        'vin' => '/VIN:\s*(?<vin>[^<]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'model' => '/Model<\/div><\/td>[^>]+>(?<model>[^<]+)/',
        'trim' => '/Trim<\/div><\/td>[^>]+>(?<trim>[^<]+)/',
    ),
  
    'images_regx' => '/class="main-slider__inner-img" src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_rustywallacenissancom_field_price", "filter_rustywallacenissancom_field_price", 10, 3);

function filter_rustywallacenissancom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/Our Price\s*<\/div>\s*<[^>]+>\s*(?<price>\$[0-9,]+)/';
    $internet_regex = '/class="price __final-price">\s*<[^>]+>\s*Internet Price\s*<\/div>\s*<[^>]+>\s*(?<price>\$[0-9,]+)/';
    $cond_final_regex = '/Our Price\s*<\/div>\s*<[^>]+>\s*<[^>]+>\s*<[^>]+>\s*<\/span>\s*<\/a>\s*(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

<?php

global $scrapper_configs;
$scrapper_configs["larryhudson"] = array(
    'entry_points' => array(
        'used' => 'https://www.larryhudson.com/used/',
        'new' => 'https://www.larryhudson.com/new/',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<div class="ajax-loading"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price' => '/itemprop="price" content="(?<price>[^"]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[0-9,]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
    //'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'description' => '/itemprop="description"[^>]+>(?<description>[^<]+)/',
        'drivetrain' => '/Drivetrain:<\/td>[^>]+>\s*(?<drivetrain>[^\s<]+)/',
        'fueltype' => '/Fuel type:<\/td>[^>]+>\s*(?<fuel_type>[^\s<]+)/',
        // 'city' => '/City:<\/td>[^>]+>\s*(?<city>[^\s<]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^>]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)"/'
);


// add_filter("filter_larryhudson_field_price", "filter_larryhudson_field_price", 10, 3);

// function filter_larryhudson_field_price($price, $car_data, $spltd_data) {
//     $prices = [];

//     slecho('');

//     if ($price && numarifyPrice($price) > 0) {
//         $prices[] = numarifyPrice($price);
//         slecho(" Price: $price");
//     }

//     $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
//     $wholesale_regex = '/itemprop="price"\s*[^>]+>(?<price>[^<]+)/';
//     $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
//     $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//     $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
//     $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


//     $matches = [];

//     if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex MSRP: {$matches['price']}");
//     }
//     if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex wholesale: {$matches['price']}");
//     }
//     if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex internet: {$matches['price']}");
//     }

//     if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Conditional Price: {$matches['price']}");
//     }

//     if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Retail Price: {$matches['price']}");
//     }
//     if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Asking Price: {$matches['price']}");
//     }

//     if (count($prices) > 0) {
//         $price = butifyPrice(min($prices));
//     }

//     slecho("Sale Price: {$price}" . '<br>');
//     return $price;
// }

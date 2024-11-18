<?php
global $scrapper_configs;
$scrapper_configs["ridgehillfordcom"] = array( 
	'entry_points' => array(
        'new' => 'https://www.ridgehillford.com/inventory/new/',
        'used' => 'https://www.ridgehillford.com/inventory/used/',
        
        
    ),
    'use-proxy' => true,
    'refine'=> false,
    'vdp_url_regex' => '/\/inventory\/(?:new|certified|used)\//i',
    'ty_url_regex' => '/\/inventory\/thank_you/i',
    'picture_selectors' => ['.vehicle-img'],
    'picture_nexts' => ['.fa-chevron-right'],
    'picture_prevs' => ['.fa-chevron-left'],
    'details_start_tag' => '<div class="large-12 column pad-top listing-grid',
    'details_end_tag' => '<footer class="footer',
    'details_spliter' => '<div class="large-4 column vehicle-container',
    'data_capture_regx' => array(
        'url' => '/vehicle-title">\s*<a itemprop="url" href="(?<url>[^"]+)"/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^\s<]+)/',
        'model' => '/itemprop="model">(?<model>[^\s<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',  
        'kilometres' => '/mileageFromOdometer">(?<kilometres>[^\s<]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine' => '/Engine:[^>]+>\s*[^>]+>(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Exterior Color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>\s*[^>]+>(?<transmission>[^\n<]+)/',
        'price' => '/Selling Price:[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" rel="next">Next/',
    'images_regx' => '/<img class="vehicle-img" data-lazy="(?<img_url>[^"]+)"/'
);

// add_filter("filter_ridgehillfordcom_field_price", "filter_ridgehillfordcom_field_price", 10, 3);

// function filter_ridgehillfordcom_field_price($price, $car_data, $spltd_data) {
//     $prices = [];

//     slecho('');

//     if ($price && numarifyPrice($price) > 0) {
//         $prices[] = numarifyPrice($price);
//         slecho(" Price: $price");
//     }

//     $msrp_regex = '/MSRP:\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s*]+)/';
//     $wholesale_regex = '/price-container vehicle-price right text-right vehicle-price-color">\s*[^>]+>[^>]+>(?<price>[^\s*]+)\s*[^>]+>\s*[^>]+>\s*<div class/';
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

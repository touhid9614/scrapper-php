<?php

global $scrapper_configs;
$scrapper_configs["priorityhondaroanoke"] = array(
    'entry_points' => array(
        'new' => 'https://www.priorityhondaroanoke.com/searchnew.aspx',
        'used' => 'https://www.priorityhondaroanoke.com/searchused.aspx'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev'],
    'details_start_tag' => '<div class="row srpSort">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle margin-x">\s*<a class="[^"]+"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">/',
     //   'title' => '/data-name="(?<title>[^"]+)"/',
        'year' => '/data-year="(?<year>[0-9]{4})"/',
        'make' => '/data-make="(?<make>[^"]+)"/',
        'model' => '/data-model="(?<model>[^"]+)"/',
        'trim' => '/data-trim="(?<trim>[^"]+)"/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price' => '/(?:MSRP:|Internet Price)\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
    'images_regx' => '/class="carousel__item--loupe js-loupe-element"><\/div>\s*<[^>]+>\s*<img src="(?<img_url>[^"]+)/',
);
add_filter('filter_priorityhondaroanoke_field_price', 'filter_priorityhondaroanoke_field_price', 10, 3);
add_filter("filter_priorityhondaroanoke_field_images", "filter_priorityhondaroanoke_field_images");

    function filter_priorityhondaroanoke_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            if(endsWith($im_url, 'photo_unavailable_640.jpg?height=400')){
                return false;
            }
            
            return true;
        });
    }

function filter_priorityhondaroanoke_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
    $price_regex = '/>Price\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }


    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
 add_filter("filter_priorityhondaroanoke_field_title", "filter_priorityhondaroanoke_field_title");
function filter_priorityhondaroanoke_field_title($title)
    {
        return str_replace('&amp;', '&', $title);
    }

<?php

global $scrapper_configs;

$scrapper_configs['velocitycars'] = array(
    'entry_points' => array(
        'used' => 'http://www.velocitycars.ca/vehicles',
    ),
    'vdp_url_regex' => '/\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['ul#gallery-thumbs div.slick-list div.slick-track li'],
    'picture_nexts'     => ['button.slick-next'],
    'picture_prevs'     => ['button.slick-prev'],
    'details_start_tag' => '<div class="row vehicle-results gallery">',
    'details_end_tag'   => '<footer>',
    'details_spliter'   => '<li class="vehicle"',
    'data_capture_regx' => array(
        'url' => '/vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s[^\n]+)/',
        'year' => '/vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s[^\n]+)/',
        'make' => '/vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s[^\n]+)/',
        'model' => '/vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s[^\n]+)/',
        'price' => '/class="price">(?<price>[^<]+)/',
        'stock_number' => '/class="stock-no">#(?<stock_number>[^<]+)/',
        'kilometres' => '/Mileage<\/div>\s.*\s*(?<kilometres>[^\n]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine' => '/Engine<\/div>\s*<div\s.*">(?<engine>[^<]+)/',
        'body_style' => '/Body<\/div>\s*<div\s.*">(?<body_style>[^<]+)/',    
        'exterior_color' => '/Ext Colour<\/div>\s*<div\s.*">(?<exterior_color>[^<]+)/',
        'transmission' => '/Transmission<\/div>\s*[^>]+>\s*(?<transmission>[^\n]+)/',
        'interior_color' => '/Interior<\/div>\s*[^>]+>\s*(?<interior_color>[^\n]+)/'
    ),
    'next_page_regx' => '/class="btn-next" href="(?<next>[^"]+)/',
    'images_regx' => '/<a[^>]+><img\ssrc="(?<img_url>[^"]+)/'
);


add_filter("filter_velocitycars_field_price", "filter_velocitycars_field_price", 10, 3);

function filter_velocitycars_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $retail_regex = '/was\s*<\/span>[^>]+>(?<price>[^<]+)/';
    $now_regex = '/now\s*<\/span>[^>]+>(?<price>[^<]+)/';

    $matches = [];

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($now_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Now: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

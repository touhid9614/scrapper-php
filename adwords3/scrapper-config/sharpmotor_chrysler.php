<?php

global $scrapper_configs;

$scrapper_configs['sharpmotor_chrysler'] = array(
    'entry_points' => array(
        'new' => 'https://www.sharpmotor.net/new-inventory/index.htm',
        'used' => 'https://www.sharpmotor.net/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}/i',
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel li'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.prev'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine( Layout)?:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s<dd>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s<dd>(?<interior_color>[^<\[]+)/',
        'kilometres' => '/Mileage:<\/dt>\s<dd>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/make: \'(?<make>[^\']+)\',/',
        'model' => '/model: \'(?<model>[^\']+)\',/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_sharpmotor_chrysler_field_images", "filter_sharpmotor_chrysler_field_images");
add_filter('filter_sharpmotor_chrysler_field_price', 'filter_sharpmotor_chrysler_field_price', 10, 3);

function filter_sharpmotor_chrysler_field_images($im_urls) {
    if (count($im_urls) < 2) {
        return array();
    }
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'photo_unavailable_320.gif');
    });
}

function filter_sharpmotor_chrysler_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
    $internet_regex = '/<strong class="h1 price" >(?<price>\$[0-9,]+)<\/strong>\s*<span class="[^>]+>Internet Price/';

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

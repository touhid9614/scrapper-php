<?php

global $scrapper_configs;

$scrapper_configs['starfordstreator'] = array(
    'entry_points' => array(
        'new' => 'https://www.starfordstreator.com/new-inventory/index.htm',
        'used' => 'https://www.starfordstreator.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'new' => array(
        'use-proxy' => true,
        'picture_selectors' => ['.slider-slide img'],
        'picture_nexts' => ['.pswp__button--arrow--right'],
        'picture_prevs' => ['.pswp__button--arrow--left'],
        'details_start_tag' => '<form id="compareForm"',
        'details_end_tag' => 'Deselect All',
        'details_spliter' => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url' => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'title' => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'year' => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'make' => '/data-make="(?<make>[^"]+)/',
            'model' => '/data-model="(?<model>[^"]+)/',
            'trim' => '/data-trim="(?<trim>[^"]+)/',
            'stock_number' => '/Stock\s*#:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'price' => '/Asking Price[^>]+>[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
            'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
            'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'kilometres' => '/Mileage<\/label>\s*<span>(?<kilometres>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(
        ),
        'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
        'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    ),
    'used' => array(
        'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">',
        'details_end_tag' => '<div class="clearfix ft">',
        'details_spliter' => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url' => '/class="inventory-title[^>]+>\s*<a href="(?<url>[^"]+)/',
            'title' => '/class="url">\s*(?<title>[^<]+)/',
            'year' => '/data-year="(?<year>[^"]+)/',
            'make' => '/data-make="(?<make>[^"]+)/',
            'model' => '/data-model="(?<model>[^"]+)/',
            'trim' => '/data-trim="(?<trim>[^"]+)/',
            'price' => '/Price[^>]+>[^>]+>[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
            'stock_number' => '/VIN<\/label>[^>]+>(?<stock_number>[^<]+)/',
            'engine' => '/Engine<\/label>[^>]+>(?<engine>[^<]+)/',
            'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission' => '/Transmission<\/label>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color' => '/Exterior Color<\/label>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/Interior Color<\/label>[^>]+>(?<interior_color>[^<]+)/',
        ),
        'next_page_regx' => '/class="btn btn-xsmall btn-xs next-btn" data-href="(?<next>[^"]+)/',
        'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
        'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    ),
);
add_filter("filter_starfordstreator_field_price", "filter_starfordstreator_field_price", 10, 3);
add_filter("filter_starfordstreator_field_images", "filter_starfordstreator_field_images");

function filter_starfordstreator_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP[^>]+>[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $final_regex = '/Final Price[^>]+>[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';



    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex final price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

function filter_starfordstreator_field_images($im_urls) {
    $retval = [];
    foreach ($im_urls as $img) {

        $retval[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }

    return $retval;
}

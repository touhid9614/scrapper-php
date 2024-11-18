<?php

global $scrapper_configs;

$scrapper_configs['perrychryslerdodgejeepram'] = array(
    'entry_points' => array(
        'new' => 'https://www.perrychryslerdodgejeepram.com/new-inventory/index.htm',
        'used' => 'https://www.perrychryslerdodgejeepram.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/final-price"><span[^>]+>[^<]+<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock:\s*<[^>]+>(?<stock_number>[^<]+)/',
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_perrychryslerdodgejeepram_field_price", "filter_perrychryslerdodgejeepram_field_price", 10, 3);

function filter_perrychryslerdodgejeepram_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Regex Sale Price: $price");
    }


    $msrp_regex = '/final-price"><span[^>]+>(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

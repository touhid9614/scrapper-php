<?php

global $scrapper_configs;

$scrapper_configs['foundationsquamishchrysler'] = array(
    'entry_points' => array(
        'new' => 'https://www.foundationsquamishchrysler.com/new-inventory/index.htm',
        'used' => 'https://www.foundationsquamishchrysler.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slider-slide'],
    'picture_nexts' => ['.slider-control-centerright'],
    'picture_prevs' => ['.slider-control-centerleft'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|salePrice|askingPrice|stackedConditionalFinal).*"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'drivetrain' => '/Engine:<\/dt>\s*<dd>(?<drivetrain>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior[^>]+>[^>]+>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior[^>]+>[^>]+>(?<interior_color>[^\<]+)/',
        'kilometres' => '/Kilometres:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
    // 'price'         => 'internetPrice final-price "[^>]+>\s*<strong class="[^>]+>(?<price>[^\<]+)'
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/id"[^"]+"uri"[^"]+"(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_foundationsquamishchrysler_field_price", "filter_foundationsquamishchrysler_field_price", 10, 3);

function filter_foundationsquamishchrysler_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
    $internet_regex = '/retailValue final-price">[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';



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

add_filter("filter_foundationsquamishchrysler_field_images", "filter_foundationsquamishchrysler_field_images");

function filter_foundationsquamishchrysler_field_images($im_urls) {

    if (count($im_urls) < 2) {
        return [];
    }
    $retvals = [];

    foreach ($im_urls as $img) {
        $retvals[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }
    return array_filter($retvals, function ($retval) {
        return !startsWith($retval, 'https://images.dealer');
    });
}

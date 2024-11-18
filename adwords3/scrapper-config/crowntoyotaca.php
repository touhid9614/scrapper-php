<?php

global $scrapper_configs;

$scrapper_configs['crowntoyotaca'] = array(
    'entry_points'           => array(
        'used' => 'https://www.crowntoyota.ca/used-vehicles-in-winnipeg-mb/',
        'new'  => 'https://www.crowntoyota.ca/new-vehicles-in-winnipeg-mb/',
    ),
    'use-proxy'              => false,
    'refine'                 => false,
    'vdp_url_regex'          => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'init_method'            => 'GET',
    'next_method'            => 'POST',
    'picture_selectors'      => ['.owl-item'],
    'picture_nexts'          => ['.owl-next'],
    'picture_prevs'          => ['.owl-prev'],
    'details_spliter'        => '<div class="vehicle-wrap">',
    'data_capture_regx'      => array(
        'stock_number' => '/Stock\s*#:\s*(?<stock_number>[^<]+)/',
        'url'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'title'        => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make'         => '/data-make="(?<make>[^"]+)/',
        'model'        => '/data-model="(?<model>[^"]+)/',
        'trim'         => '/data-trim="(?<trim>[^"]+)/',
        'price'        => '/Your Price\s*<\/span>\s*<span class="price">\s*(?<price>\$[0-9,]+)/',
        'kilometres'   => '/Kilometers:\s*(?<kilometres>[^\n<]+)/',
        'biweekly'     => '/(?:class="price-label lease-payment-text visible-xs">LEASE<\/span>\s*|Or Finance For:\s*<\/span>)\s*[^>]+>\s*.*\s*(?<biweekly>\$[0-9,.]+)/',
        'msrp'         => '/MSRP\s*<\/span>\s*<[^>]+>\s*(?<msrp>\$\s*[0-9,.]+)/',
    ),
    'data_capture_regx_full' => array(
        'vin'            => '/VIN<\/span><[^>]+>(?<vin>[^<]+)/',
        'body_style'     => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
        'year'           => '/data-vehicle=\'{"model_year":"(?<year>[^"]+)/',
        'make'           => '/data-vehicle=\'{"model_year":"[^"]+","make":"(?<make>[^"]+)/',
        'model'          => '/data-vehicle=\'{"model_year":"[^"]+","make":"[^"]+","model":"(?<model>[^"]+)/',
        'kilometres'     => '/Mileage:<\/dt>\s*<dd>\s*(?<kilometres>[^<]+)/',
        'engine'         => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior:<\/dt>\s*<dd>\s*(?<interior_color>[^<]+)/',
        'transmission'   => '/Trans:<\/dt>\s*<dd>\s*(?<transmission>[^<]+)/',
    ),
    'next_query_regx'        => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx'            => '/<img class="lazyOwl"[^"]+"(?<img_url>[^"]+)/',
);

add_filter('filter_crowntoyotaca_post_data', 'filter_crowntoyotaca_post_data', 10, 3);
add_filter('filter_crowntoyotaca_data', 'filter_crowntoyotaca_data');
add_filter("filter_crowntoyotaca_field_price", "filter_crowntoyotaca_field_price", 10, 3);
add_filter('filter_crowntoyotaca_car_data', 'filter_crowntoyotaca_car_data');
add_filter("filter_crowntoyotaca_field_images", "filter_crowntoyotaca_field_images");

$crowntoyotaca_nonce = '';

function filter_crowntoyotaca_post_data($post_data, $stock_type, $data)
{
    global $crowntoyotaca_nonce;
    if ($post_data == '') {
        $post_data = "page=1";
    }

    $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
    $nonce       = '';
    $matches     = [];

    if ($data && preg_match($nonce_regex, $data, $matches)) {
        $nonce = $matches['nonce'];
    }
    slecho("ajax_nonce : " . $nonce);
    if ($nonce && isset($nonce)) {
        $crowntoyotaca_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $crowntoyotaca_nonce);
    $post_id = 6;
    $referer = '/new-vehicles-in-winnipeg-mb/';

    if ($stock_type == 'used') {
        $post_id = 7;
        $referer = '/used-vehicles-in-winnipeg-mb/';
    }

    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$crowntoyotaca_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_crowntoyotaca_data($data)
{
    if ($data) {
        if (isJSON($data)) {
            slecho("data is in jSon format");
            $obj = json_decode($data);

            $data = "{$obj->results}\n{$obj->pagination}";
        } else {
            slecho("data is not in jSon format");
        }
    }

    return $data;
}

function filter_crowntoyotaca_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex       = '/MSRP\s*<\/span>\s*<[^>]+>\s*(?<price>\$[0-9,]+)/';
    $wholesale_regex  = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex   = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/<span class="price-label">\s*Price\s*<\/span>\s*<span class="price">\s*(?<price>\$[0-9,]+)/';
    $retail_regex     = '/retailValue"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $asking_regex     = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';

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
        if ($price >= 100000) {
            $price = "please call";
        }
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

function filter_crowntoyotaca_car_data($car_data)
{
    if ($car_data['stock_type'] == 'new') {
        $car_data['price'] = $car_data['msrp'];
    }

    return $car_data;
}

function filter_crowntoyotaca_field_images($im_urls)
{
    if (count($im_urls) < 5) {
        return [];
    }

    return $im_urls;
}
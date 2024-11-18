<?php

global $scrapper_configs;
$scrapper_configs["championchryslerdodgemississippicom"] = array(
    "entry_points" => array(
        'new' => 'https://www.championchryslerdodgemississippi.com/new-vehicles/',
        'used' => 'https://www.championchryslerdodgemississippi.com/used-vehicles/'
    ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used)-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<div class="grid-view-results-wrapper">',
    // 'details_end_tag' => '<div id="footer">',
    'details_spliter' => '<div class="vehicle-wrap">',
    'data_capture_regx' => array(
        'title' => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/Conditional\s*Final\s*Price<\/span>\s*<[^>]+>(?<price>\$[0-9,]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/'
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock<\/span><span\s*[^>]+>(?<stock_number>[^<]+)/',
        'vin' => '/VIN<\/span><span\s*[^>]+>(?<vin>[^<]+)/',
        'engine' => '/<dt>Engine:<\/dt>\s*<dd>\s*(?<engine>[^\s*]+)/',
        'exterior_color' => '/<dt>Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^\s*]+)/',
        'transmission' => '/<dt>Trans:<\/dt>\s*<dd>\s*(?<transmission>[^\s*]+)/',
        'kilometres' => '/<dt>Mileage:<\/dt>\s*<dd>\s*(?<kilometres>[^\s*]+)/',
    ),
    'next_query_regx' => '/class="(?<param>price)"(?<value>>)/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
);
add_filter('filter_championchryslerdodgemississippicom_post_data', 'filter_championchryslerdodgemississippicom_post_data', 10, 3);
add_filter('filter_championchryslerdodgemississippicom_data', 'filter_championchryslerdodgemississippicom_data');

$championchryslerdodgemississippicom_page_num = 0;
$championchryslerdodgemississippicom_nonce = '';

function filter_championchryslerdodgemississippicom_post_data($post_data, $stock_type, $data) {
    global $championchryslerdodgemississippicom_nonce;
    global $championchryslerdodgemississippicom_page_num;
    if ($post_data == '') {
        $post_data = "page=1";
    }

    $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
    $nonce = '';
    $matches = [];

    if ($data && preg_match($nonce_regex, $data, $matches)) {
        $nonce = $matches['nonce'];
    }
    slecho("ajax_nonce : " . $nonce);
    if ($nonce && isset($nonce)) {
        $championchryslerdodgemississippicom_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $championchryslerdodgemississippicom_nonce);
    $post_id = 4;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 5;
        $referer = '/used-vehicles/';
    }
    $championchryslerdodgemississippicom_page_num++;
    return "action=im_ajax_call&perform=get_results&page=$championchryslerdodgemississippicom_page_num&_nonce=$championchryslerdodgemississippicom_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_championchryslerdodgemississippicom_data($data) {
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

add_filter("filter_championchryslerdodgemississippicom_field_price", "filter_championchryslerdodgemississippicom_field_price", 10, 3);

function filter_championchryslerdodgemississippicom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/Champion Value<\/span>\s*<[^>]+>(?<price>\$[0-9,]+)/';
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

<?php

global $scrapper_configs;
$scrapper_configs["timdahlemurray"] = array(
    'entry_points' => array(
        'new' => 'https://www.timdahlemurray.com/new-vehicles/',
        'used' => 'https://www.timdahlemurray.com/used-vehicles/',
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\//i',
    'ty_url_regex' => '/\/thank-you-for-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.swiper-slide'],
    'picture_nexts' => ['.swiper-button-next'],
    'picture_prevs' => ['.swiper-button-prev'],
    'details_start_tag' => '<div class="grid-view-results-wrapper">',
    // 'details_end_tag'   => '<div class="resultsPagination paging  pagination-bottom">',
    'details_spliter' => '<div class="vehicle-wrap">',
    'data_capture_regx' => array(
        'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/(?:Retail Price|Internet Price)<\/span>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'vin' => '/VIN:\s*<span>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
         'vin' => '/VIN<\/span><span class="vinstock-number">(?<vin>[^<]+)/',
        'stock_number' => '/Stock<\/span><span class="vinstock-number">(?<stock_number>[^<]+)/',
        'make' => '/make:\s*\'(?<make>[^\']+)/',
        'model' => '/model:\s*\'(?<model>[^\']+)/',
        'body_style' => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
        'kilometres' => 'Mileage:<\/dt>\s*<dd>\s*(?<kilometres>[^<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
        'transmission' => '/Trans:<\/dt>\s*<dd>\s*(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior:<\/dt>\s*<dd>\s*(?<interior_color>[^<]+)/',
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<img class="swiper-lazy" data-src="(?<img_url>[^"]+)"/'
);

add_filter('filter_timdahlemurray_post_data', 'filter_timdahlemurray_post_data', 10, 3);
add_filter('filter_timdahlemurray_data', 'filter_timdahlemurray_data');
add_filter("filter_timdahlemurray_field_images", "filter_timdahlemurray_field_images");


$timdahlemurray_nonce = '';

function filter_timdahlemurray_post_data($post_data, $stock_type, $data) {
    global $timdahlemurray_nonce;
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
        $timdahlemurray_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $timdahlemurray_nonce);
    $post_id = 6;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 7;
        $referer = '/used-vehicles/';
    }

    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$timdahlemurray_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_timdahlemurray_data($data) {
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

function filter_timdahlemurray_field_images($im_urls) {
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}

add_filter('filter_keywords_timdahlemurray', 'filter_keywords_timdahlemurray', 10, 3);

function filter_keywords_timdahlemurray($keywords, $car, $directive) {

    $additional_keywords1 = array();
    $additional_keywords2 = array();
    if ($directive == 'search') {
        foreach ($keywords as $key => $value) {
            $keyw1 = str_replace("+", "", $value);
            $additional_keywords1[$key] = "\"$keyw1\"";
            $additional_keywords2[$key] = "[$keyw1]";
        }
    }

    return array_merge($keywords, $additional_keywords1, $additional_keywords2);
}

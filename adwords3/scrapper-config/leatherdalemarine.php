<?php

global $scrapper_configs;
$scrapper_configs["leatherdalemarine"] = array(
    'entry_points' => array(
        'new' => 'https://leatherdalemarine.com/New-inventory/',
        'used' => 'https://leatherdalemarine.com/used-inventory'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/(?:New|Used)-(?:inventory|Inventory)\/[^\/]+\/[0-9]{8}/i',
    'refine' => false,
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.lslide img'],
    'picture_nexts' => ['.lSNext'],
    'picture_prevs' => ['.lSPrev'],
    'details_start_tag' => '<div class="container-fluid listing-view">',
    'details_end_tag' => '<!-- End Model Row -->',
    'details_spliter' => '<div class="model-row">',
    'data_capture_regx' => array(
        'title' => '/class="model-title[^>]+>(?<title>(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'year' => '/class="model-title[^>]+>(?<title>(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make' => '/class="model-title[^>]+>(?<title>(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/class="model-title[^>]+>(?<title>(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'price' => '/(?:Our Price:[^>]+><span>|MSRP: <span>|Our Price:<\/span>)(?<price>\$\s*[0-9,]+)/',
        'url' => '/class="thumbnail-container"><a class="View-Details pushstate" href="(?<url>[^"]+)">/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/ID:<\/strong>\s*(?<stock_number>[^<]+)/',
        'exterior_color' => '/Color\s*</div>\n+\s+[^\n]+\s+(?<exterior_color>[^<]+)/',
        'year' => '/Year[^\n]+\s*[^\n]+\s*(?<year>[^<]+)/',
        'make' => '/Manufacturer[^\n]+\s*[^\n]+\s*(?<make>[^<]+)/',
        'model' => '/Model[^\n]+\s*[^\n]+\s*(?<model>[^<]+)/',
        'price' => '/Our Price:<\/span>\s*(?<price>[^<]+)/',
    ),
    'next_query_regx' => '/href="\/New-inventory\/(?<param>page)\/(?<value>[0-9]*)[^>]+>Next/',
    'images_regx' => '/data-src="(?<img_url>[^"]+)"/'
);

add_filter('filter_leatherdalemarine_post_data', 'filter_leatherdalemarine_post_data', 10, 3);
add_filter('filter_leatherdalemarine_data', 'filter_leatherdalemarine_data');


$leatherdalemarine_nonce = '';

function filter_leatherdalemarine_post_data($post_data, $stock_type, $data) {
    global $leatherdalemarine_nonce;
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
        $leatherdalemarine_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $leatherdalemarine_nonce);
    $post_id = 5;
    $referer = '/new-vehicles/';

   if ($stock_type == 'used') {
       $post_id = 6;
       $referer = '/used-vehicles/';
    }

    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$leatherdalemarine_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_leatherdalemarine_data($data) {
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

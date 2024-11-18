<?php

global $scrapper_configs;

$scrapper_configs['safiestahonda'] = array(
    'entry_points' => array(
        'new' => 'http://www.safiestahonda.com/new-vehicles/',
        'used' => 'http://www.safiestahonda.com/used-vehicles/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(certified-)?(?:new|used)-[0-9]{4}-.*/i',
    'ty_url_regex' => '/\/thank-you-/i',
    'init_method'  => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<table class="results_table">',
    'details_end_tag' => '</table>',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'stock_number' => '/data-vehicle=\'.*"stock":"(?<stock_number>[^"]+)/',
        'title' => '/vehicle-title">\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<title>(Certified\s*)?(?:New|Pre-Owned)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
        'year' => '/vehicle-title">\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<title>(Certified\s*)?(?:New|Pre-Owned)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
        'make' => '/vehicle-title">\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<title>(Certified\s*)?(?:New|Pre-Owned)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
        'model' => '/vehicle-title">\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<title>(Certified\s*)?(?:New|Pre-Owned)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
        'trim' => '/vehicle-title">\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<title>(Certified\s*)?(?:New|Pre-Owned)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
       // 'certified' => '/vehicle-title">\s*<h2>\s*<a\s*href="[^"]+">\s*(?<certified>Certified)[^<]+/',
        'price' => '/<span class="price">[<strong>]*(?<price>\$[0-9,]+)/',
        'exterior_color' => '/data-vehicle=\'.*"ext_color":"(?<exterior_color>[^"]+)/',
        'interior_color' => '/data-vehicle=\'.*"int_color":"(?<interior_color>[^"]+)/',
        'kilometres' => '/data-vehicle=\'.*"miles":"(?<kilometres>[^"]+)/',
        'url' => '/vehicle-title">\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<title>(Certified\s*)?(?:New|Pre-Owned)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/'
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/<meta itemprop="sku"\s*content="(?<stock_number>[^"]+)/',
        'make' => '/<meta itemprop="brand"\s*content="(?<make>[^"]+)/',
        'model' => '/<meta itemprop="model"\s*content="(?<model>[^"]+)/',
        'transmission' => '/Trans:<\/dt>\s*<dd>\s*(?<transmission>[^<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
        'body_style' => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/'
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter('filter_safiestahonda_post_data', 'filter_safiestahonda_post_data', 10, 3);
add_filter('filter_safiestahonda_data', 'filter_safiestahonda_data');

// $safiestahonda_nonce = '';

function filter_safiestahonda_post_data($post_data, $stock_type, $data) {
    global $safiestahonda_nonce;
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
        $safiestahonda_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $safiestahonda_nonce);
    $post_id = 4;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 5;
        $referer = '/used-vehicles/';
    }

   
    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$safiestahonda_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_safiestahonda_data($data) {
    global $safiestahonda_nonce;
    if ($data) {
        if (isJSON($data)) {
            slecho("data is in jSon format");
            $obj = json_decode($data);

            $data = "{$obj->results}\n{$obj->pagination}\n\"ajax_nonce\":\"{$safiestahonda_nonce}\"\n\"page_count\" :\"{$obj->page_count}\"";
        } else {
            slecho("data is not in jSon format");
        }
    }

    return $data;
}

function filter_safiestahonda_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'notfound.jpg');
    });
}

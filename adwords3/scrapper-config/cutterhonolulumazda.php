<?php

global $scrapper_configs;

$scrapper_configs['cutterhonolulumazda'] = array(
    'entry_points' => array(
        'new' => 'https://www.cutterhonolulumazda.com/new-vehicles/',
        'used' => 'https://www.cutterhonolulumazda.com/used-vehicles/'
    ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used)-[0-9]{4}-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<table class="results_table">',
    'details_end_tag' => '</table>',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'stock_number' => '/<span class="stock-label">Stock\s*#:\s*(?<stock_number>[^<]+)/',
        'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make=\'(?<make>[^\']+)/',
        'model' => '/data-model=\'(?<model>[^\']+)/',
        'trim' => '/data-trim=\'(?<trim>[^\']+)/',
        'price' => '/(?:Your Price|Sale Price)<\/span>\s*<span.*(?<price>\$[0-9,]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'kilometres' => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/'
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/'
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
);

add_filter('filter_cutterhonolulumazda_post_data', 'filter_cutterhonolulumazda_post_data', 10, 3);
add_filter('filter_cutterhonolulumazda_data', 'filter_cutterhonolulumazda_data');
add_filter("filter_cutterhonolulumazda_field_images", "filter_cutterhonolulumazda_field_images");

$cutterhonolulumazda_nonce = '';

function filter_cutterhonolulumazda_post_data($post_data, $stock_type, $data) {
    global $cutterhonolulumazda_nonce;
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
        $cutterhonolulumazda_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $cutterhonolulumazda_nonce);
    $post_id = 4;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 5;
        $referer = '/used-vehicles/';
    }
    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$cutterhonolulumazda_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_cutterhonolulumazda_data($data) {
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

function filter_cutterhonolulumazda_field_images($im_urls) {
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}

add_filter("filter_cutterhonolulumazda_next_page", "filter_cutterhonolulumazda_next_page", 10, 2);

function filter_cutterhonolulumazda_next_page($next_page_regex) {
    slecho("Filtering Next url");
    return str_replace('?', '', $next_page_regex);
}

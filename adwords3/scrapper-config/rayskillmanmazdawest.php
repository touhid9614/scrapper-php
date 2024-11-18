<?php

global $scrapper_configs;
$scrapper_configs["rayskillmanmazdawest"] = array(
    "entry_points" => array(
        'new' => 'https://www.rayskillmanmazdawest.com/new-vehicles/',
        'used' => 'https://www.rayskillmanmazdawest.com/used-vehicles/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['div.gallery-thumbs > div > div.owl-wrapper-outer > div > div'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<td class="results gridview">',
   // 'details_end_tag' => '<div class="disclaimer-small">',
    'details_spliter' => '<div class="vrp_modals">',
    'data_capture_regx' => array(
        'url' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Used|Pre-Owned)(?<title>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'year' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Used|Pre-Owned)(?<title>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'make' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Used|Pre-Owned)(?<title>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'model' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Used|Pre-Owned)(?<title>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'title' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Used|Pre-Owned)(?<title>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'price' => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine' => '/<dt>Engine:<\/dt>\s*<dd>(?<engine>[^<]*)/',
        'stock_number' => '/Stock<\/span><[^>]*>(?<stock_number>[^<]*)/',
        'kilometres' => '/Mileage:<\/dt>\s[^>]*>\s(?<kilometres>[^<]+)/',
        'transmission' => '/Trans:<\/dt>\s[^>]*>\s(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior:<\/dt>\s[^>]*>\s(?<exterior_color>[^<]+)/',
        'body_style' => '/Body:<\/dt>\s[^>]*>\s(?<body_style>[^<]+)/'
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)/'
);

add_filter('filter_rayskillmanmazdawest_post_data', 'filter_rayskillmanmazdawest_post_data', 10, 3);
add_filter('filter_rayskillmanmazdawest_data', 'filter_rayskillmanmazdawest_data');
add_filter("filter_rayskillmanmazdawest_field_images", "filter_rayskillmanmazdawest_field_images");

$rayskillmanmazdawest_nonce = '';

function filter_rayskillmanmazdawest_post_data($post_data, $stock_type, $data) {
    global $rayskillmanmazdawest_nonce;
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
        $rayskillmanmazdawest_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $rayskillmanmazdawest_nonce);
    $post_id = 4;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 5;
        $referer = '/used-vehicles/';
    }
    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$rayskillmanmazdawest_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_rayskillmanmazdawest_data($data) {
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

function filter_rayskillmanmazdawest_field_images($im_urls) {
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}

add_filter("filter_rayskillmanmazdawest_next_page", "filter_rayskillmanmazdawest_next_page", 10, 2);

function filter_rayskillmanmazdawest_next_page($next_page_regex) {
    slecho("Filtering Next url");
    return str_replace('?', '', $next_page_regex);
}

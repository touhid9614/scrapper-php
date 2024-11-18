<?php

global $scrapper_configs;
$scrapper_configs["postfallschryslerjeepdodgeram"] = array(
    "entry_points" => array(
        'new' => 'https://www.postfallschryslerjeepdodgeram.com/new-vehicles/',
        'used' => 'https://www.postfallschryslerjeepdodgeram.com/used-vehicles/'
    ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used|certified)-[0-9]{4}-/i',
    'init_method'       => 'GET',
    'next_method'       => 'POST',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => false,
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<div class="grid-view-results-wrapper">',
    //'details_end_tag' => '</table>',
    'details_spliter' => '<div class="vehicle-wrap">',
    'data_capture_regx' => array(
        
        'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make=\'(?<make>[^\']+)/',
        'model' => '/data-model=\'(?<model>[^\']+)/',
        'price' => '/(?:Findlay Price|Price)<\/span>\s*[^>]+>(?<price>[^<]+)/',
       'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>[^<]+)/',

    ),
    'data_capture_regx_full' => array(
                'exterior_color' => '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^\n<]+)/',
                'interior_color' => '/Interior:<\/dt>\s*<dd>\s*(?<interior_color>[^\n<]+)/',
                'engine' => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^\n<]+)/',
    'transmission' => '/Trans:<\/dt>\s*<dd>\s*(?<transmission>[^\n<]+)/',
      'kilometres' => '/Mileage:<\/dt>\s*<dd>\s*(?<kilometres>[^<]+)/',
      'stock_number' => '/Stock<\/span><span class="vinstock-number">(?<stock_number>[^<]+)/',
      'vin' => '/VIN<\/span><span class="vinstock-number">(?<vin>[^<]+)/',
  
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[^"]+)" class="next">/',
    'images_regx' => '/<img class="lazyOwl" (?:data-src|src)="(?<img_url>[^"]+)"/'
);




add_filter('filter_postfallschryslerjeepdodgeram_post_data', 'filter_postfallschryslerjeepdodgeram_post_data', 10, 3);
add_filter('filter_postfallschryslerjeepdodgeram_data', 'filter_postfallschryslerjeepdodgeram_data');
add_filter("filter_postfallschryslerjeepdodgeram_field_images", "filter_postfallschryslerjeepdodgeram_field_images");

$postfallschryslerjeepdodgeram_nonce = '';

function filter_postfallschryslerjeepdodgeram_post_data($post_data, $stock_type, $data) {
    global $postfallschryslerjeepdodgeram_nonce;
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
        $postfallschryslerjeepdodgeram_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $postfallschryslerjeepdodgeram_nonce);
    $post_id = 4;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 5;
        $referer = '/used-vehicles/';
    }
    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$postfallschryslerjeepdodgeram_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_postfallschryslerjeepdodgeram_data($data) {
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

function filter_postfallschryslerjeepdodgeram_field_images($im_urls) {
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}

add_filter("filter_postfallschryslerjeepdodgeram_next_page", "filter_postfallschryslerjeepdodgeram_next_page", 10, 2);

function filter_postfallschryslerjeepdodgeram_next_page($next_page_regex) {
    slecho("Filtering Next url");
    return str_replace('?', '', $next_page_regex);
}

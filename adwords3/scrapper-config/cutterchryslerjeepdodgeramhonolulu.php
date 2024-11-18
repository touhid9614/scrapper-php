<?php
global $scrapper_configs;
 $scrapper_configs["cutterchryslerjeepdodgeramhonolulu"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.cutterchryslerjeepdodgeramhonolulu.com/new-vehicles/',
        'used' => 'https://www.cutterchryslerjeepdodgeramhonolulu.com/used-vehicles/'
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
        'price' => '/(?:MSRP|Sale Price)<\/span>\s*[^>]+>(?<price>[^<]+)/',
        'engine' => '/Engine:<\/span>\s*<span class="[^>]+> (?<engine>[^<]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*<span class="[^>]+> (?<kilometres>[^<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
         'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>[^<]+)/',
//        'interior_color' => '/Int. Color:<\/span>\s*(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
       // 'make' => '/make":\s*"(?<make>[^"]+)/',
      //  'model' => '/model":\s*"(?<model>[^"]+)/',
      //  'trim' => '/trim":\s*"(?<trim>[^"]+)/',
    ),
     'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
     'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
);

 
 
 
add_filter('filter_cutterchryslerjeepdodgeramhonolulu_post_data', 'filter_cutterchryslerjeepdodgeramhonolulu_post_data', 10, 3);
add_filter('filter_cutterchryslerjeepdodgeramhonolulu_data', 'filter_cutterchryslerjeepdodgeramhonolulu_data');
add_filter("filter_cutterchryslerjeepdodgeramhonolulu_field_images", "filter_cutterchryslerjeepdodgeramhonolulu_field_images");

$cutterchryslerjeepdodgeramhonolulu_nonce = '';

function filter_cutterchryslerjeepdodgeramhonolulu_post_data($post_data, $stock_type, $data) {
    global $cutterchryslerjeepdodgeramhonolulu_nonce;
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
        $cutterchryslerjeepdodgeramhonolulu_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $cutterchryslerjeepdodgeramhonolulu_nonce);
    $post_id = 4;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 5;
        $referer = '/used-vehicles/';
    }
    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$cutterchryslerjeepdodgeramhonolulu_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_cutterchryslerjeepdodgeramhonolulu_data($data) {
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

function filter_cutterchryslerjeepdodgeramhonolulu_field_images($im_urls) {
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}

add_filter("filter_cutterchryslerjeepdodgeramhonolulu_next_page", "filter_cutterchryslerjeepdodgeramhonolulu_next_page", 10, 2);

function filter_cutterchryslerjeepdodgeramhonolulu_next_page($next_page_regex) {
    slecho("Filtering Next url");
    return str_replace('?', '', $next_page_regex);
}

<?php

global $scrapper_configs;

$scrapper_configs['helmsmotor'] = array(
    'entry_points' => array(
        'new' => 'https://www.helmsmotor.com/new-vehicles/',
        'used' => 'https://www.helmsmotor.com/used-vehicles/'
    ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
//    'ty_url_regex' => '/\/thank-you-for-/i',
//    'use-proxy' => true,
//    'init_method' => 'GET',
//    'next_method' => 'POST',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<table class="results_table">',
    'details_end_tag' => '<div class="resultsPagination paging',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'url' => '/<div class="vehicle-title.*>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'year' => '/<div class="vehicle-title.*>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'make' => '/<div class="vehicle-title.*>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'model' => '/<div class="vehicle-title.*>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'title' => '/<div class="vehicle-title.*>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'price' => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'stock_number' => '/Stock #:\s*(?<stock_number>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*<span[^>]+>\s*(?<kilometres>[^<]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)/'
);
//add_filter('filter_helmsmotor_post_data', 'filter_helmsmotor_post_data', 10, 2);
//add_filter('filter_helmsmotor_data', 'filter_helmsmotor_data');
//
//function filter_helmsmotor_post_data($post_data, $stock_type) {
//    if ($post_data == '') {
//        $post_data = "page=1";
//    }
//
//    $post_id = 4;
//    $referer = '/new-vehicles/';
//
//    if ($stock_type == 'used') {
//        $post_id = 5;
//        $referer = '/used-vehicles/';
//    }
//
//    return "action=im_ajax_call&perform=get_results&_post_id=$post_id&$post_data&show_all_filters=false&_referer=$referer";
//}
//
//function filter_helmsmotor_data($data) {
//    if ($data) {
//        $obj = json_decode($data);
//
//        $data = "{$obj->results}\n{$obj->pagination}";
//    }
//
//    return $data;
//}

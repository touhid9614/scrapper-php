<?php

global $scrapper_configs;

$scrapper_configs['leesmith'] = array(
    'entry_points' => array(
        'used' => 'http://trucks.lee-smith.com/vehicle-search?type=Used&size=50',
        'new' => 'http://trucks.lee-smith.com/vehicle-search?type=New&size=50',
    ),
    'vdp_url_regex' => '/\/vehicle-detail\?/i',
    //'ty_url_regex'      => '/\/thankYou.do/i',
    // 'ajax_url_match'    => 'callback=secureLeadSubmission',
    'required_params' => ['id'],
    'use-proxy' => true,
//    'init_method' => 'GET',
//    'next_method' => 'POST',
    'picture_selectors' => ['.vehicle-slide .pagination ul li'],
    'picture_nexts' => [],
    'picture_prevs' => [],
    'details_start_tag' => '<div class="block-holder js-view-blocks">',
    'details_end_tag' => '<div id="footer">',
    'details_spliter' => '<div class="compare-item">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock#:<\/strong>\s*<span>\s*(?<stock_number>[^<]+)/',
        'price' => '/<dt>PRICE[^>]+>\s*<dd>(?<price>\$[0-9,]+)/',
        'title' => '/<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'year' => '/<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make' => '/<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'kilometres' => '/Mileage:<\/strong>\s*<span>\s*(?<kilometres>[^\n]+)/',
        'url' => '/<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
    ),
    'data_capture_regx_full' => array(
        'price' => '/PRICE:[^<]+<\/strong>\s*<span>\s*(?<price>\$[0-9,]+)/',
        'transmission' => '/Transmission<\/strong><span>(?<transmission>[^<]+)/',
        //   'exterior_color'    => '/Color<\/strong><span>(?<exterior_color>[^<]+)/',
        'body_style' => '/Body Type<\/strong><span>(?<body_style>[^<]+)/',
    ),
    //  'next_page_regx'    => '/<li class="active">[^<]+<\/li><li><a href="(?<next>[^"]+)/',
    'images_regx' => '/<div class="img-holder">\s*<img src="(?<img_url>[^"]+)" height="340" width="575"/',
        // 'images_fallback_regx'  => '/<a href="\#"><img src="(?<img_url>[^"]+)/'
);

//add_filter('filter_leesmith_post_data', 'filter_leesmith_post_data', 10, 3);
//add_filter('filter_leesmith_data', 'filter_leesmith_data');
//
//
//$leesmith_nonce = '';
//
//function filter_leesmith_post_data($post_data, $stock_type, $data) {
//    global $leesmith_nonce;
//    if ($post_data == '') {
//        $post_data = "page=1";
//    }
//
//    $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
//    $nonce = '';
//    $matches = [];
//
//    if ($data && preg_match($nonce_regex, $data, $matches)) {
//        $nonce = $matches['nonce'];
//    }
//    slecho("ajax_nonce : " . $nonce);
//    if ($nonce && isset($nonce)) {
//        $leesmith_nonce = $nonce;
//    }
//    slecho("global ajax_nonce : " . $leesmith_nonce);
//    $post_id = 5;
//    $referer = '/new-vehicles/';
//
//    if ($stock_type == 'used') {
//        $post_id = 6;
//        $referer = '/used-vehicles/';
//    }
//
//    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$leesmith_nonce&_post_id=$post_id&_referer=$referer";
//}
//
//function filter_leesmith_data($data) {
//    if ($data) {
//        if (isJSON($data)) {
//            slecho("data is in jSon format");
//            $obj = json_decode($data);
//
//            $data = "{$obj->results}\n{$obj->pagination}";
//        } else {
//            slecho("data is not in jSon format");
//        }
//    }
//
//    return $data;
//}

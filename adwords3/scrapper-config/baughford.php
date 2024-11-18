<?php

global $scrapper_configs;

$scrapper_configs['baughford'] = array(
    'entry_points' => array(
        'new' => 'https://www.baughford.net/searchnew.aspx',
        'used' => 'https://www.baughford.net/searchused.aspx'
    ),
//    'init_method' => 'GET',
//    'next_method' => 'POST',
    'vdp_url_regex' => '/\/(?:new|used)-[^-]*-[0-9]{4}-/i',
    'picture_selectors' => ['.img-responsive'],
    'picture_nexts' => ['.mfp-arrow-right.mfp-prevent-close'],
    'picture_prevs' => ['.mfp-arrow-left.mfp-prevent-close'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'model' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'trim' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'body_style' => '/class="[^"]+ ">\s*<li class="[^"]+"><strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)<\/li>\s*<li class="ext/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)<\/li>\s*<li class="drive/',
        'exterior_color' => '/Transmission:.*\s*<li class="extColor"><strong>Ext. Color: <\/strong>(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/class="intColor"><strong>Int. Color: <\/strong>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price' => '/class="pull-right primaryPrice">(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'trim' => '/var vehicleTrim="(?<trim>[^"]+)/',
        'make' => '/var vehicleMake="(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
    'images_regx' => '/<img class=\'img-responsive\' src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);


//add_filter('filter_baughford_post_data', 'filter_baughford_post_data', 10, 3);
//add_filter('filter_baughford_data', 'filter_baughford_data');
//
//
//$baughford_nonce = '';
//
//function filter_baughford_post_data($post_data, $stock_type, $data) {
//    global $baughford_nonce;
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
//        $baughford_nonce = $nonce;
//    }
//    slecho("global ajax_nonce : " . $baughford_nonce);
//    $post_id = 5;
//    $referer = '/new-vehicles/';
//
//    if ($stock_type == 'used') {
//        $post_id = 6;
//        $referer = '/used-vehicles/';
//    }
//
//    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$baughford_nonce&_post_id=$post_id&_referer=$referer";
//}
//
//function filter_baughford_data($data) {
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

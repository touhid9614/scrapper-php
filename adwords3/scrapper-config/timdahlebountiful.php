<?php

global $scrapper_configs;

$scrapper_configs['timdahlebountiful'] = array(
    'entry_points' => array(
        'used' => 'https://www.timdahlebountiful.com/used-vehicles/',
        'new' => 'https://www.timdahlebountiful.com/new-vehicles/',
        
    ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/i',
     'init_method' => 'GET',
    'next_method' => 'POST',
  'picture_selectors' => ['.swiper-slide'],
        'picture_nexts'     => ['.swiper-button-next'],
        'picture_prevs'     => ['.swiper-button-prev'],
    'details_start_tag' => '<table class="results_table">',
    'details_end_tag' => '</table>',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:\s*(?<stock_number>[^<]+)/',
        'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
          'vin' => '/VIN:\s*(?<vin>[^<]+)/',
        'price' => '/Internet Price<\/span>\s*<span class="[^>]+>(?<price>\$[0-9,]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'kilometres' => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/make:\s*\'(?<make>[^\']+)/',
        'model' => '/model:\s*\'(?<model>[^\']+)/',
        'body_style' => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<img class="swiper-lazy" data-src="(?<img_url>[^"]+)"/'
);

add_filter('filter_timdahlebountiful_post_data', 'filter_timdahlebountiful_post_data', 10, 3);
add_filter('filter_timdahlebountiful_data', 'filter_timdahlebountiful_data');

$timdahlebountiful_nonce = '';

function filter_timdahlebountiful_post_data($post_data, $stock_type, $data) {
    global $timdahlebountiful_nonce;
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
        $timdahlebountiful_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $timdahlebountiful_nonce);
    $post_id = 6;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 7;
        $referer = '/used-vehicles/';
    }
    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$timdahlebountiful_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_timdahlebountiful_data($data) {
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
add_filter("filter_timdahlebountiful_field_price", "filter_timdahlebountiful_field_price", 10, 3);

function filter_timdahlebountiful_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP<\/span>\s*[^>]+>(?<price>[^<]+)/';
   
    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
  
  
  

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

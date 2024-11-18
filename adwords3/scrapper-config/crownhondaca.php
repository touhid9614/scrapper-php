<?php

global $scrapper_configs;

$scrapper_configs['crownhondaca'] = array(
    'entry_points' => array(
        'new' => 'https://www.crownhonda.ca/new-vehicles-in-winnipeg-mb/',
        'used' => 'https://www.crownhonda.ca/used-vehicles-in-winnipeg-mb/',
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
//    'details_start_tag' => '<div class="grid-view-results-wrapper">',
//     'details_end_tag' => '<div class="prefooter">',
//    'details_spliter' => '<div class="vehicle-wrap">',
    'details_spliter' => '"hidden-xs',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:\s*(?<stock_number>[^<]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/Your Price\s*<\/span>\s*<span class="price">\s*(?<price>\$[0-9,]+)/',
        'kilometres' => '/Kilometers:\s*(?<kilometres>[^\n<]+)/',
        //'lease'      => '/(?:Or Finance For:\s*<\/span>\s*<[^>]+>\s*|>FINANCE<\/span>\s*<\/div>\s*<[^>]+>\s*)(?<biweekly>\$[0-9,.]+)/',
        'biweekly'  => '/>LEASE<\/span>\s*<\/div>\s*<[^>]+>\s*(?<lease>\$[0-9,.]+)/',
        'msrp'   => '/MSRP\s*<\/span>\s*<[^>]+>\s*(?<msrp>\$\s*[0-9,.]+)/',
    ),
    'data_capture_regx_full' => array(
        'vin' => '/VIN<\/span><[^>]+>(?<vin>[^<]+)/',
        'exterior_color' => '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
        'engine' => '/<dt>Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
        'transmission' => '/<dt>Trans:<\/dt>\s*<dd>\s*(?<transmission>[^<]+)/',
        //'stock_number' => '/Stock<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',


        'year' => '/data-vehicle=\'{"model_year":"(?<year>[^"]+)/',
        'make' => '/data-vehicle=\'{"model_year":"[^"]+","make":"(?<make>[^"]+)/',
        'model' => '/data-vehicle=\'{"model_year":"[^"]+","make":"[^"]+","model":"(?<model>[^"]+)/',
        
        'kilometres' => '/Mileage:<\/dt>\s*<dd>\s*(?<kilometres>[^<]+)/',
        'interior_color' => '/Interior:<\/dt>\s*<dd>\s*(?<interior_color>[^<]+)/',
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<img class="lazyOwl"[^"]+"(?<img_url>[^"]+)/'
);

add_filter('filter_crownhondaca_post_data', 'filter_crownhondaca_post_data', 10, 3);
add_filter('filter_crownhondaca_data', 'filter_crownhondaca_data');

$crownhondaca_nonce = '';

function filter_crownhondaca_post_data($post_data, $stock_type, $data) {
    global $crownhondaca_nonce;
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
        $crownhondaca_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $crownhondaca_nonce);
    $post_id = 6;
    $referer = '/new-vehicles-in-winnipeg-mb/';

    if ($stock_type == 'used') {
        $post_id = 7;
        $referer = '/used-vehicles-in-winnipeg-mb/';
    }

    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$crownhondaca_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_crownhondaca_data($data) {
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

add_filter("filter_crownhondaca_field_price", "filter_crownhondaca_field_price", 10, 3);

function filter_crownhondaca_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP\s*<\/span>\s*<[^>]+>\s*(?<price>\$[0-9,]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/<span class="price-label">\s*Price\s*<\/span>\s*<span class="price">\s*(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
        if($price>=100000){
            $price="please call";
        }
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}


add_filter('filter_crownhondaca_car_data', 'filter_crownhondaca_car_data');

function filter_crownhondaca_car_data($car_data) {

    if($car_data['stock_type'] == 'new') {
        $car_data['price'] = $car_data['msrp'];
    }

    return $car_data;
}
add_filter("filter_crownhondaca_field_images", "filter_crownhondaca_field_images");
    
    function filter_crownhondaca_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }
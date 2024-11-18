<?php
global $scrapper_configs;
$scrapper_configs["infinitiofnapervillecom"] = array( 
	"entry_points" => array(
        'new' => 'https://www.infinitiofnaperville.com/new-vehicles/',
        'used' => 'https://www.infinitiofnaperville.com/used-vehicles/'
    ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'refine' => false,
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
  // 'details_start_tag' => '<div class="grid-view-results-wrapper">',
  //  'details_end_tag' => '<footer',
    'details_spliter' => '<div class="vehicle-wrap">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock:\s*(?<stock_number>[^\s]+)/', 
        'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'model' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'price' => '/Sale Price<\/span>\s*<span class="price">(?<price>\$[0-9,]+)/',
        'exterior_color' => '/Exterior:\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:\s*(?<interior_color>[^\n<]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/'
    ),
    'data_capture_regx_full' => array(
        'vin' => '/VIN<\/span>[^>]+>(?<vin>[^<]+)/',
        'transmission' => '/Trans:[^>]+>\s*[^>]+>\s*(?<transmission>[^\n<]+)/',
        'engine' => '/Engine:<\/dt>\s*[^>]+>\s*(?<engine>[^\n<]+)/',
        'kilometres' => '/Mileage:\s*[^>]+>\s*[^>]+>\s*(?<kilometres>[^\n<]+)/',
        'body_style' => '/Body:\s*[^>]+>\s*[^>]+>\s*(?<body_style>[^<]+)/',
    ),
    'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx'       => '/<img class="lazyOwl" (?:data-src|src)="(?<img_url>[^"]+)/'
);

add_filter('filter_infinitiofnapervillecom_post_data', 'filter_infinitiofnapervillecom_post_data', 10, 3);
add_filter('filter_infinitiofnapervillecom_data', 'filter_infinitiofnapervillecom_data');

$infinitiofnapervillecom_page_num = 0;
$infinitiofnapervillecom_nonce = '';

function filter_infinitiofnapervillecom_post_data($post_data, $stock_type, $data) {
    global $infinitiofnapervillecom_nonce;
    global $infinitiofnapervillecom_page_num;
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
        $infinitiofnapervillecom_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $infinitiofnapervillecom_nonce);
    $post_id = 6;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 7;
        $referer = '/used-vehicles/';
    }
    $infinitiofnapervillecom_page_num++;
    return "action=im_ajax_call&perform=get_results&page=$infinitiofnapervillecom_page_num&_nonce=$infinitiofnapervillecom_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_infinitiofnapervillecom_data($data) {
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

add_filter("filter_infinitiofnapervillecom_field_price", "filter_infinitiofnapervillecom_field_price", 10, 3);

function filter_infinitiofnapervillecom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP<\/span>\s*<span class="price">(?<price>\$[0-9,]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/Our Price<\/span>\s*<span class="price">(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
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
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

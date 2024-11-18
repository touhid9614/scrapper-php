<?php
global $scrapper_configs;
$scrapper_configs["butlerlexussouthatlantacom"] = array( 
	 'entry_points' => array(
            'new'    => 'https://www.butlerlexussouthatlanta.com/new-vehicles/',
            'used'   => 'https://www.butlerlexussouthatlanta.com/used-vehicles/'
        ),
       'vdp_url_regex'     => '/\/inventory\/(certified-)?(?:new|used)-[0-9]{4}-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'refine'    => false,
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<table class="results_table">',
   // 'details_end_tag' => '<footer id="footer',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'stock_number' => '/<span class="stock-label">Stock\s*#:\s*(?<stock_number>[^<]+)/',
        'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make=\'(?<make>[^\']+)/',
        'model' => '/data-model=\'(?<model>[^\']+)/',
        'trim' => '/data-trim=\'(?<trim>[^\']+)/',
        'price' => '/Price<\/span>\s*<span class="price">(?<price>\$[0-9,]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'kilometres' => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/'
    ),
    'data_capture_regx_full' => array(
         'body_style'    => '/Body:\s*[^>]+>\s*[^>]+>\s*(?<body_style>[^<]+)/',
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<img class="lazyOwl" data-src="(?<img_url>[^"]+)"/'
);

add_filter('filter_butlerlexussouthatlantacom_post_data', 'filter_butlerlexussouthatlantacom_post_data', 10, 3);
add_filter('filter_butlerlexussouthatlantacom_data', 'filter_butlerlexussouthatlantacom_data');


$butlerlexussouthatlantacom_nonce = '';

function filter_butlerlexussouthatlantacom_post_data($post_data, $stock_type, $data) {
    global $butlerlexussouthatlantacom_nonce;
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
        $butlerlexussouthatlantacom_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $butlerlexussouthatlantacom_nonce);
    $post_id = 6;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 7;
        $referer = '/used-vehicles/';
    }
    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$butlerlexussouthatlantacom_nonce&_post_id=$post_id&_referer=$referer";

} 

function filter_butlerlexussouthatlantacom_data($data) {
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

add_filter("filter_butlerlexussouthatlantacom_next_page", "filter_butlerlexussouthatlantacom_next_page", 10, 2);

 function filter_butlerlexussouthatlantacom_next_page($next_page_regex) {
     slecho("Filtering Next url");
    return str_replace('?', '', $next_page_regex);
 }


add_filter("filter_butlerlexussouthatlantacom_field_price", "filter_butlerlexussouthatlantacom_field_price", 10, 3);

function filter_butlerlexussouthatlantacom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP[^>]+>\s*[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/Internet Price[^>]+>\s*[^>]+>(?<price>[^<]+)/';
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

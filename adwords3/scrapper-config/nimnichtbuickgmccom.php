<?php
global $scrapper_configs;
$scrapper_configs["nimnichtbuickgmccom"] = array(
    'entry_points'           => array(
        'new'  => 'https://www.nimnichtbuickgmc.com/new-vehicles/',
        'used' => 'https://www.nimnichtbuickgmc.com/used-vehicles/',
    ),
    'use-proxy'              => true,
    'vdp_url_regex'          => '/\/inventory\/(certified-)?(?:new|used)-[0-9]{4}-/i',
    'ty_url_regex'           => '/\/thank-you-for-/i',
    'init_method'            => 'GET',
    'next_method'            => 'POST',
    'picture_selectors'      => ['.owl-item'],
    'picture_nexts'          => ['.owl-next'],
    'picture_prevs'          => ['.owl-prev'],
    'details_start_tag'      => '<table class="results_table">',
    'details_end_tag'        => '</table>',
    'details_spliter'        => '<tr class="spacer">',
    'data_capture_regx'      => array(
        'stock_number'   => '/Stock #:\s*(?<stock_number>[^<]+)/',
        'title'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make'           => '/data-make="(?<make>[^"]+)/',
        'model'          => '/data-model="(?<model>[^"]+)/',
        'trim'           => '/data-trim="(?<trim>[^"]+)/',
        'price'          => '/Internet Price[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'transmission'   => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'engine'         => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'kilometres'     => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
        'url'            => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
    ),
    'next_query_regx'        => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx'            => '/lazyOwl" (?:data-src|src)="(?<img_url>[^"]+)/',
);

add_filter('filter_nimnichtbuickgmccom_post_data', 'filter_nimnichtbuickgmccom_post_data', 10, 3);
add_filter('filter_nimnichtbuickgmccom_data', 'filter_nimnichtbuickgmccom_data');
add_filter("filter_nimnichtbuickgmccom_field_price", "filter_nimnichtbuickgmccom_field_price", 10, 3);
add_filter("filter_nimnichtbuickgmccom_field_images", "filter_nimnichtbuickgmccom_field_images");

$nimnichtbuickgmccom_nonce = '';

function filter_nimnichtbuickgmccom_post_data($post_data, $stock_type, $data)
{
    global $nimnichtbuickgmccom_nonce;
    if ($post_data == '') {
        $post_data = "page=1";
    }

    $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
    $nonce       = '';
    $matches     = [];

    if ($data && preg_match($nonce_regex, $data, $matches)) {
        $nonce = $matches['nonce'];
    }
    slecho("ajax_nonce : " . $nonce);
    if ($nonce && isset($nonce)) {$nimnichtbuickgmccom_nonce = $nonce;}
    slecho("global ajax_nonce : " . $nimnichtbuickgmccom_nonce);
    $post_id = 4;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 5;
        $referer = '/used-vehicles/';
    }
    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$nimnichtbuickgmccom_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_nimnichtbuickgmccom_data($data)
{
    if ($data) {
        if (isJSON($data)) {
            slecho("data is in jSon format");
            $obj = json_decode($data);

            $data = "{$obj->results}\n{$obj->pagination}";
        } else {slecho("data is not in jSon format");}
    }

    return $data;
}

function filter_nimnichtbuickgmccom_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Final Price: $price");
    }

    $msrp_regex    = '/MSRP<\/span>\s*<span[^>]+>(?<price>\$[0-9,]+)/';
    $selling_regex = '/Sale Price As Low As[^>]+>[^>]+>\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($selling_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
function filter_nimnichtbuickgmccom_field_images($im_urls)
{
    return array_filter($im_urls, function ($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}
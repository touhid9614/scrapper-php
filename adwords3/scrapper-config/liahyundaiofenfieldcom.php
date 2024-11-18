<?php

global $scrapper_configs;
$scrapper_configs["liahyundaiofenfieldcom"] = array(
    "entry_points" => array(
        'new' => 'https://www.liahyundaiofenfield.com/searchnew.aspx?Dealership=Lia%20Hyundai%20of%20Enfield',
        'used' => 'https://www.liahyundaiofenfield.com/searchused.aspx?Dealership=Lia%20Hyundai%20of%20Enfield',
    ),
    'use-proxy' => true,
    'refine'=>false,
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}/i',
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div id="srpRow',
    'data_capture_regx' => array(
        'stock_number' => '/Stock\s*#:\s*<\/strong>\s*(?<stock_number>[^<]+)/',
        'title' => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
        'year' => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
        'make' => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
        'model' => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
        'price' => '/Internet Price\s*<\/span>\s*<span[^"]+"[^"]+" class="pull-right[^>]+>(?<price>[$0-9,]+)/',
        'engine' => '/Engine: <\/strong>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:\s*<\/strong>\s*(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color:\s*<\/strong>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. Color:\s*<\/strong>\s*(?<interior_color>[^<]+)/',
        'kilometres' => '/Mileage:\s*<\/strong>\s*(?<kilometres>[^<]+)/',
        'url' => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
        'body_style' => '/Body Style:\s*<\/strong>\s*(?<body_style>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
);
add_filter("filter_liahyundaiofenfieldcom_field_price", "filter_liahyundaiofenfieldcom_field_price", 10, 3);

function filter_liahyundaiofenfieldcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }



    $internet_regex = '/NADA Book Value:\s*[^>]+>[^>]+>(?<price>[$0-9,]+)/';
    $retail_regex = '/MSRP:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';
    $msrp_regex = '/LIA PRICE:\s*[^>]+>[^>]+>(?<price>[$0-9,]+)/';
    $cond_final_regex = '/Our Price:\s*[^>]+>[^>]+>(?<price>[$0-9,]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
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

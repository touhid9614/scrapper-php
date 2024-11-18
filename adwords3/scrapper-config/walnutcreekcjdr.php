<?php

global $scrapper_configs;

$scrapper_configs['walnutcreekcjdr'] = array(
    'entry_points' => array(
        'new' => 'https://www.walnutcreekcjdr.com/new-inventory/index.htm',
        'used' => 'https://www.walnutcreekcjdr.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.jcarousel li'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
        'stock_number' => '/VIN: <\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        'interior_color' => '/Interior Color<\/span>\s*.*\s*<span[^>]+>(?<interior_color>[^<]+)/',
        
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
    
);
//add_filter("filter_walnutcreekcjdr_field_price", "filter_walnutcreekcjdr_field_price", 10, 3);
//add_filter("filter_walnutcreekcjdr_field_images", "filter_walnutcreekcjdr_field_images");
//
//function filter_walnutcreekcjdr_field_price($price, $car_data, $spltd_data) {
//    $prices = [];
//
//    slecho('');
//
//    if ($price && numarifyPrice($price) > 0) {
//        $prices[] = numarifyPrice($price);
//        slecho(" Price: $price");
//    }
//
//    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
//    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
//    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
//    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//    $retail_regex = '/retailValue"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//
//
//    $matches = [];
//
//    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//        slecho("Regex MSRP: {$matches['price']}");
//    }
//    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//        slecho("Regex wholesale: {$matches['price']}");
//    }
//    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//        slecho("Regex internet: {$matches['price']}");
//    }
//
//    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//        slecho("Regex Conditional Price: {$matches['price']}");
//    }
//
//    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//        slecho("Regex Retail Price: {$matches['price']}");
//    }
//    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//        slecho("Regex Asking Price: {$matches['price']}");
//    }
//
//    if (count($prices) > 0) {
//        $price = butifyPrice(min($prices));
//    }
//
//    slecho("Sale Price: {$price}" . '<br>');
//    return $price;
//}
//
//function filter_walnutcreekcjdr_field_images($im_urls) {
//    $retval = [];
//
//    foreach ($im_urls as $img) {
//        $retval[] = str_replace('|', '%7c', $img);
//    }
//
//    return $retval;
//}

<?php

global $scrapper_configs;
$scrapper_configs["ulmerchev"] = array(
    'entry_points' => array(
        'new' => 'https://www.ulmerchev.com/inventory/new/',
        'used' => 'https://www.ulmerchev.com/inventory/used/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i',
    'picture_selectors' => ['.owl-item.cloned'],
    'picture_nexts' => ['#newnext'],
    'picture_prevs' => ['#newprev'],
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'class="carbox-wrap',
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        'year' => '/class="vehicle-title--year">\s*(?<year>[0-9]{4})/',
        'make' => '/class="notranslate vehicle-title--make ">\s*(?<make>[^<]+)/',
        'model' => '/class="notranslate vehicle-title--model ">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>\s*(?<stock_number>[^<]+)/',
        'price' => '/class="currency">\$[^>]+>(?<price>[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx' => '/data-lightbox="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_ulmerchev_field_price", "filter_ulmerchev_field_price", 10, 3);
add_filter("filter_ulmerchev_field_images", "filter_ulmerchev_field_images");

function filter_ulmerchev_field_images($im_urls) {
    if(count($im_urls) < 2) { return array(); }
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "7257f3c75ca48eb9a7679f54829a1ff.jpg");
    }
    );
}


function filter_ulmerchev_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/class="numbers">(?<price>[0-9,]+)/';
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

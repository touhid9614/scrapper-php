<?php
global $scrapper_configs;
$scrapper_configs["brantfordnissancom"] = array(
    "entry_points"           => array(
        'new'  => 'https://brantfordnissan.com/inventory/?condition=new-cars',
        'used' => 'https://brantfordnissan.com/inventory/?condition=used-cars',
    ),
    'vdp_url_regex'          => '/.com\/listings\//i',

    'use-proxy'              => true,
    'refine'                 => false,

    'picture_selectors'      => ['.owl-item'],
    'picture_nexts'          => ['.owl-next', '.fancybox-next'],
    'picture_prevs'          => ['.owl-prev', '.fancybox-prev'],

    'details_start_tag'      => '<div id="listings-result">',
    'details_end_tag'        => '<footer',
    'details_spliter'        => '<div class="listing-list-loop',
    'data_capture_regx'      => array(
        'url'          => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'title'        => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year'         => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make'         => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model'        => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'price'        => '/OUR PRICE[^>]+>\s*[^>]+>(?<price>[^<]+)/',
        'kilometres'   => '/Mileage<\/div>\s*[^>]+>\s*[^>]+>\s*(?<kilometres>[^<]+)/',
        'stock_number' => '/stock#[^>]+>(?<stock_number>[^<]+)/',
        'vin'          => '/data-vin="(?<vin>[^"]+)"/',
        'engine'       => '/Engine.*\s*[^\s]*\s+[^>]*>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission[^\n]+\s*.*\s*<div[^\n]+\s*(?<transmission>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'exterior_color' => '/Exterior Color<\/td>\s*<td[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color<\/td>\s*<td[^>]+>(?<interior_color>[^<]+)/',
    ),
    'next_page_regx'         => '/<a class="next page-numbers"\s*href="(?<next>[^"]+)"/',
    // 'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="stm_fancybox"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)/',
);

add_filter("filter_brantfordnissancom_field_price", "filter_brantfordnissancom_field_price", 10, 3);

function filter_brantfordnissancom_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex       = '/<span class="heading-font">(?<price>[^<]+)/';
    $wholesale_regex  = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex   = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex     = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex     = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';

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

add_filter("filter_brantfordnissancom_field_images", "filter_brantfordnissancom_field_images");
function filter_brantfordnissancom_field_images($im_urls)
{
    $retval = [];

    foreach ($im_urls as $img) {
        $start    = strrpos($img, "http");
        $retval[] = substr($img, $start);
    }

    return $retval;
}

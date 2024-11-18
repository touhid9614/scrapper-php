<?php
global $scrapper_configs;
$scrapper_configs["simanautosales"] = array(
    'entry_points'           => array(
        'new'   => 'https://www.simanautosales.com/new/',
        'used' => 'https://www.simanautosales.com/used/',
    ),
    'srp_page_regex'         => '/\/(?:new|used|certified)/i',
    'vdp_url_regex'          => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-.*-[0-9A-Za-z]{4,17}/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="',
    'details_spliter'        => '<div class="veh-img-placeholder">',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span/',
        'year'           => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer[^>]+>[^>]+>(?<make>[^\<]+)/',
        'model'          => '/itemprop=\'model[^>]+>[^>]+>(?<model>[^\<]+)/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
        'vin'            => '/id="vin-(?<vin>[^\"]+)/',
        'fuel_type' => '/Fuel[^>]+>[^>]+>(?<fuel_type>[^<]+)/',
    ),
    'next_page_regx'         => '/class="active"><a\s*href="">[^>]+><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx'            => '/imgError\(this\)\;"\s*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_simanautosales_field_price", "filter_simanautosales_field_price", 10, 3);
add_filter("filter_simanautosales_field_images", "filter_simanautosales_field_images");
function filter_simanautosales_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
    }

    $msrp_regex      = '/MSRP:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
    $suggested_regex = '/Suggested Price:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
    $final_regex     = '/Final Price:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
    $price_regex     = '/>Price:<\/span>\s*<span[^>]+>[\S\s]+?itemprop="price"[^>]+>(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($suggested_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    return $price;
}
function filter_simanautosales_field_images($im_urls)
{
    return array_filter($im_urls, function ($im_url) {
        return !endsWith($im_url, 'no_image-640x480.jpg');
    });
}

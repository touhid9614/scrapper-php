<?php

global $scrapper_configs;

$scrapper_configs['northsideused'] = array(
    'entry_points' => array(
        'used' => 'https://www.northsideused.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
      'refine'=> false,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<div id="bottom-footer">',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
       'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price' => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
     //   'price' => '/Cash<\/span><span[^>]+>\s*(?<price>\$[0-9,]+)/',
    ),
   'next_page_regx' => '/class="active">[^>]+>[0-9]+[^>]+>[^>]+>\s*[^>]+><a\s*href="(?<next>[^"]+)/',
   'images_regx' => '/<img onerror="imgError\(this\);" (?:data-src|src)="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_northsideused_field_images", "filter_northsideused_field_images");

add_filter("filter_northsideused_field_price", "filter_northsideused_field_price", 10, 3);

function filter_northsideused_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'no_image-640x480.jpg');
    });
}

function filter_northsideused_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("cartercdjr Price: $price");
    }

    $original_regex = '/>Original Price:[\S\s]*?itemprop="price" content="(?<price>[0-9,]+)/';
    $price_regex = '/>Price:[\S\s]*?itemprop="price" content="(?<price>[0-9,]+)/';
    $msrp_regex = '/>MSRP[\S\s]*?itemprop="price" content="(?<price>[0-9,]+)/';


    $matches = [];

    if (preg_match($original_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex original price: {$matches['price']}");
    }

    if (preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex price: {$matches['price']}");
    }
    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

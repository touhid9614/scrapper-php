<?php
global $scrapper_configs;
$scrapper_configs["gladstonemitsubishicom"] = array( 
    'entry_points' => array(
        'new' => 'https://www.gladstonemitsubishi.com/new-mitsubishi-portland-or?limit=1000/',
        'used' => 'https://www.gladstonemitsubishi.com/used-vehicles-portland-or?limit=1000/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-/i',
    // 'ty_url_regex' => '/\/thank-you-for-/i',
  
    'picture_selectors' => ['.thumbnails__thumbnail'],
    'picture_nexts' => ['.df-icon.df-icon-chevron-right.icon'],
    'picture_prevs' => ['.df-icon.df-icon-chevron-left.icon'],

    'details_start_tag' => 'class="clearfix js-layout-header-block"',
    'details_end_tag' => '<footer class="no-print"',
    'details_spliter' => '<div class="inventory-item_info',
    'data_capture_regx' => array(
        'url' => '/<a\s*href="(?<url>[^"]+)"\s*class="vehicle-title\s*">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<moel>[^\s*]+)/',            
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/class="name_wrapper">Stock[^>]+>[^>]+>\s*[^>]+>(?<stock_number>[^<]+)[^>]+>/',
        'vin' => '/VIN[^>]+>[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'price' => '/<div\s*class="price_value">\s*(?<price>[^\s*]+)\s*<\/div>/',
        'year' => '/>Year[^>]+>[^>]+>\s*[^>]+>(?<year>[^<]+)/',
        'make' => '/>Make[^>]+>[^>]+>\s*[^>]+>(?<make>[^<]+)/',
        'model' => '/>Model[^>]+>[^>]+>\s*[^>]+>(?<model>[^<]+)/',
        'trim' => '/>Trim[^>]+>[^>]+>\s*[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/>Exterior Color[^>]+>[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/>Interior Color[^>]+>[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'price' => '/Price\s*<\/div>\s*<div\s*class="price_value">\s*(?<price>[^\s<]+)/',
    ),
        
    // 'next_page_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/class="main-slider__inner-img"\s*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_gladstonemitsubishicom_field_price", "filter_gladstonemitsubishicom_field_price", 10, 3);

function filter_gladstonemitsubishicom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/class="price-rules-link js-price-rules-link">\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s*]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
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

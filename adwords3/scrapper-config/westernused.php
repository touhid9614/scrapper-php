<?php

global $scrapper_configs;
$scrapper_configs["westernused"] = array(
    "entry_points" => array(
        'used' => 'https://westernused.com/collections/all',
    ),
    'vdp_url_regex' => '/\/products\/[0-9]{4}-/i',
    'srp_page_regex' => '/collections/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.carousel-item img'],
    'picture_nexts' => ['.slider-button--next'],
    'picture_prevs' => ['.slider-button--prev'],
    'details_start_tag' => '<ul id="product-grid"',
    'details_end_tag' => '<footer class',
    'details_spliter' => '<li class="grid__item">',
    'data_capture_regx' => array(
        'url' => '/class="card__heading h5">\s*<a href="(?<url>[^"]+)/',
        'year' => '/class="card__heading h5">\s*<a href="(?<url>[^"]+)"[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
        'make' => '/class="card__heading h5">\s*<a href="(?<url>[^"]+)"[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
        'model' => '/class="card__heading h5">\s*<a href="(?<url>[^"]+)"[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
        'price' => '/price-item price-item--regular">\s*\$(?<price>[^\s*]+)/',
        'kilometres' => '/class="mileage">(?<kilometres>[^\s*]+)\s*km/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock Number:[^>]+>\s*(?<stock_number>[^<]+)/',
        'vin' => '/VIN[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>\s*(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:[^>]+>\s*(?<exterior_color>[^<]+)/',
        'body_style' => '/Body<\/td>\s*[^>]+>(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="pagination__item[^"]+" aria-label="Next page"/',
    'images_regx' => '/<div class="product__media[^>]+>\s*<img\s*srcset="(?<img_url>[^\s]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_westernused_field_images", "filter_westernused_field_images");

function filter_westernused_field_images($im_urls) {
    if (count($im_urls) < 2) {
        return [];
    }

    return $im_urls;
}

add_filter('filter_for_fb_westernused', 'filter_for_fb_westernused', 10, 2);

function filter_for_fb_westernused($car_data, $feed_type) {
    
    if (strpos($car_data['all_images'], "products/comsoon") || strpos($car_data['all_images'], "products/Just_20Arrived")) {
        
        return null;
        $car_data['all_images'] = "";
    }



    return $car_data;
}

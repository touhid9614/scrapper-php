<?php

global $scrapper_configs;

$scrapper_configs['cookiekits'] = array(
    'entry_points' => array(
        'new' => 'https://cookiekits.ca/product-category/cookies/',
        'used' => 'https://cookiekits.ca/product-category/bites/',
    ),
    'vdp_url_regex' => '/\/shop\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.ps-product__image a img'],
    'picture_nexts' => ['.lg-next'],
    'picture_prevs' => ['.lg-prev'],
    'details_start_tag' => '<div class="ps-section--page with-sidebar-right',
    'details_end_tag' => '<footer class="ps-footer">',
    'details_spliter' => '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12',
    'data_capture_regx' => array(
        'url' => '/<a class="ps-product__title" href="(?<url>[^"]+)">\s*(?<title>[^<]+)/',
        'title' => '/<a class="ps-product__title" href="(?<url>[^"]+)">\s*(?<title>[^<]+)/',
        'make' => '/<a class="ps-product__title" href="(?<url>[^"]+)">\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
        'model' => '/<a class="ps-product__title" href="(?<url>[^"]+)">\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
        'price' => '/ps-product__price">[^>]+><span class="woocommerce-Price-currencySymbol">[^<]+<\/span>(?<price>[0-9,.]+)<\/span>/',
    ),
    'data_capture_regx_full' => array(
    ),
    ///there is no next page right now because the website is totally new!!///
    //'next_page_regx' => '//',
    'images_regx' => '/<div class="ps-product__image">\s*<a href="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);



add_filter('filter_cookiekits_car_data', 'filter_cookiekits_car_data');

function filter_cookiekits_car_data($car_data) {


    $car_data['make'] = str_replace('&#038;', " & ", $car_data['make']);
    $car_data['title'] = str_replace('&#038;', " & ", $car_data['title']);


    return $car_data;
}

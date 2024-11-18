<?php
global $scrapper_configs;
$scrapper_configs["shoprockys_harleycom"] = array(
    'entry_points'           => array(
        'new' => array(
            'https://shop.rockys-harley.com/collections/for-him',
            'https://shop.rockys-harley.com/collections/for-her',
            'https://shop.rockys-harley.com/collections/for-kids',
            'https://shop.rockys-harley.com/collections/for-home',
            'https://shop.rockys-harley.com/collections/ride-bells',
            'https://shop.rockys-harley.com/collections/backpacks-and-luggage',
            'https://shop.rockys-harley.com/collections/harley-davidson%C2%AE-footwear',
            'https://shop.rockys-harley.com/collections/headwear-masks',
            'https://shop.rockys-harley.com/collections/helmets',
            'https://shop.rockys-harley.com/collections/jewelry-watches',
            'https://shop.rockys-harley.com/collections/last-change-good-buys',
        ),

    ),
    'vdp_url_regex'          => '/com\/collections\//i',

    'details_start_tag'      => '<ul class="grid grid--uniform grid--view-items">',
    'details_spliter'        => '<li class="grid__item grid__item--collection-templat',

    'data_capture_regx'      => array(
        'url'   => '/<a class="grid-view-item__link[^"]+"\s*href="(?<url>[^"]+)"/',
        'make'  => '/<a class="grid-view-item__link[^"]+"\s*href="(?<url>[^"]+)">[^>]+>(?<make>[^\s]+)/',
        'model' => '/<a class="grid-view-item__link[^"]+"\s*href="(?<url>[^"]+)">[^>]+>(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price' => '/<span class="price-item price-item--regular">(?<price>\$[0-9,.]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx'         => '/<a href="(?<next>[^"]+)" class="btn btn--tertiary btn--narrow">/',
    'images_regx'            => '/data-image-zoom-wrapper data-zoom="(?<img_url>[^"]+)/',
);

add_filter('filter_shoprockys_harleycom_field_url', 'filter_shoprockys_harleycom_field_url');
add_filter('filter_shoprockys_harleycom_car_data', 'filter_shoprockys_harleycom_car_data');

function filter_shoprockys_harleycom_field_url($url)
{
    slecho("URL:" . $url);
    return $url;
}

function filter_shoprockys_harleycom_car_data($car_data)
{
    $car_data['make'] = str_replace('®', '', $car_data['make']);
    $car_data['make'] = str_replace('Â', '', $car_data['make']);
    $car_data['make'] = str_replace("'", "", $car_data['make']);
    $car_data['make'] = str_replace('-', '', $car_data['make']);

    $car_data['model'] = str_replace('#', '', $car_data['model']);
    $car_data['model'] = str_replace('&', '', $car_data['model']);
    $car_data['model'] = str_replace('®', '', $car_data['model']);
    $car_data['model'] = str_replace('Â', '', $car_data['model']);
    $car_data['model'] = str_replace("'", "", $car_data['model']);
    $car_data['model'] = str_replace("â„¢", "", $car_data['model']);
    $car_data['model'] = str_replace(",", "", $car_data['model']);
    $car_data['model'] = str_replace('-', '', $car_data['model']);
    $car_data['model'] = str_replace('|', '', $car_data['model']);
    $car_data['model'] = str_replace('.', '', $car_data['model']);

    $car_data['title'] = str_replace('#', '', $car_data['title']);
    $car_data['title'] = str_replace('&', '', $car_data['title']);
    $car_data['title'] = str_replace('®', '', $car_data['title']);
    $car_data['title'] = str_replace('Â', '', $car_data['title']);
    $car_data['title'] = str_replace("'", "", $car_data['title']);
    $car_data['title'] = str_replace("â„¢", "", $car_data['title']);
    $car_data['title'] = str_replace(",", "", $car_data['title']);
    $car_data['title'] = str_replace("|", "", $car_data['title']);
    $car_data['title'] = str_replace("-", "", $car_data['title']);
    $car_data['title'] = str_replace("â€™", "", $car_data['title']);
    $car_data['title'] = str_replace(".", "", $car_data['title']);

    return $car_data;
}
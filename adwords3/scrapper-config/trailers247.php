<?php
global $scrapper_configs;
$scrapper_configs["trailers247"] = array(
    'entry_points'           => array(
        'used' => array(
            'https://trailers247.ca/current-inventory/',
            'https://trailers247.ca/goosenecks/',
            'https://trailers247.ca/cargo-trailers-current-inventory/',
            'https://trailers247.ca/car-hauler-utility-trailers/',
            'https://trailers247.ca/deckover-trailers/',
            'https://trailers247.ca/dump-trailers/',
            'https://trailers247.ca/equipment-tilt-trailers/',
        ),
    ),
    'use-proxy'              => true,
    'vdp_url_regex'          => '/product\/.*(?:new|preowned)-/i',
    'ty_url_regex'           => '/\/inventory\/thank_you/i',

    'picture_selectors'      => ['.woocommerce-product-gallery__image'],
    'picture_nexts'          => ['.pp_arrow_previous'],
    'picture_prevs'          => ['.pp_arrow_previous'],

    'details_start_tag'      => '<div class="wpb_column',
    'details_end_tag'        => '<footer',
    'details_spliter'        => '<div class="trailer-list-content-holder',

    'data_capture_regx'      => array(
        'url'         => '/class="trailer-list-image"><a href="(?<url>[^"]+)"/',
        'year'        => '/<div class="trailer-list-title"><a href="(?<url>[^"]+)"[^>]+><p>\s*(?<title>(?:New|Preowned|NEW|PreOwned|)\s*(?:(?<year>[0-9]{4})| )\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)?[^<]*)/',
        'make'        => '/<div class="trailer-list-title"><a href="(?<url>[^"]+)"[^>]+><p>\s*(?<title>(?:New|Preowned|NEW|PreOwned|)\s*(?:(?<year>[0-9]{4})| )\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)?[^<]*)/',
        'model'       => '/<div class="trailer-list-title"><a href="(?<url>[^"]+)"[^>]+><p>\s*(?<title>(?:New|Preowned|NEW|PreOwned|)\s*(?:(?<year>[0-9]{4})| )\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)?[^<]*)/',
        'price'       => '/Price:[^>]+>\s*(?<price>\$[0-9,]+)/',
        'description' => '/<div class="trailer-list-description"><p>\s*(?<description>[^<]+)</',

    ),

    'data_capture_regx_full' => array(
        'custom' => '/(?:Category|Categories):[^>]+>(?<custom>[^<]+)</',
    ),

    //'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx'            => '/<div data-thumb="(?<img_url>[^"]+)"/',
);
add_filter('filter_trailers247_car_data', 'filter_trailers247_car_data');

function filter_trailers247_car_data($car_data)
{

    $car_data['make'] = str_replace('&#8243;', ' foot ', $car_data['make']);
    $car_data['make'] = str_replace('&#8242;', ' inches ', $car_data['make']);

    $car_data['model'] = str_replace('&#8243;', ' foot ', $car_data['model']);
    $car_data['model'] = str_replace('&#8242;', ' inches ', $car_data['model']);

    $car_data['title'] = str_replace('&#8242;', ' inches ', $car_data['title']);
    $car_data['title'] = str_replace('&#8243;', ' foot ', $car_data['title']);

    $car_data['make']  = str_replace('&#8211;', '', $car_data['make']);
    $car_data['model'] = str_replace('&#8211;', '', $car_data['model']);
    $car_data['title'] = str_replace('&#8211;', '', $car_data['title']);

    $car_data['make']  = str_replace('&#215;', ' X ', $car_data['make']);
    $car_data['model'] = str_replace('&#215;', ' X ', $car_data['model']);
    $car_data['title'] = str_replace('&#215;', ' X ', $car_data['title']);

    $car_data['make']  = str_replace('&#8217;', "'", $car_data['make']);
    $car_data['model'] = str_replace('&#8217;', "'", $car_data['model']);
    $car_data['title'] = str_replace('&#8217;', "'", $car_data['title']);

    $car_data['make']  = str_replace('&#038;', " & ", $car_data['make']);
    $car_data['model'] = str_replace('&#038;', " & ", $car_data['model']);
    $car_data['title'] = str_replace('&#038;', " & ", $car_data['title']);

    $car_data['make']  = str_replace('&#8203;', " ", $car_data['make']);
    $car_data['model'] = str_replace('&#8203;', " ", $car_data['model']);
    $car_data['title'] = str_replace('&#8203;', " ", $car_data['title']);

    $car_data['vin']            = substr($car_data['stock_number'], 0, 16);
    $car_data['exterior_color'] = "Trailers";
    $car_data['body_style']     = "Trailers";

    slecho("custom data: " . $car_data['custom']);

    return $car_data;
}

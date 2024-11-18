<?php
global $scrapper_configs;
$scrapper_configs["jamestowncanamseadoocom"] = array(
    "entry_points"           => array(
        'used' => 'https://jamestowncanamseadoo.com/preowned-inventory?page=1',
        'new'  => 'https://jamestowncanamseadoo.com/new-inventory?page=1',
    ),
    'vdp_url_regex'          => '/\/inventory\/[^\/]+\/(?:new|used)-[0-9]{4}-/',
    'refine'                 => false,
    'use-proxy'              => true,
    'details_start_tag'      => '<section class="mainContent-wrapper">',
    'details_end_tag'        => '<footer class="container-fullWidth">',
    'details_spliter'        => '<li class="inventoryList-bike">',
    'picture_selectors'      => ['.r58-slider-slide'],
    'picture_nexts'          => ['.right'],
    'picture_prevs'          => ['.left'],

    'data_capture_regx'      => array(
        'url'            => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'year'           => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'make'           => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'model'          => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'kilometres'     => '/Mileage:<\/td>[^>]+>(?<kilometres>[0-9,]+)/',
        'stock_number'   => '/Stock number:<\/td>[^>]+>(?<stock_number>[^<]+)/',
        'exterior_color' => '/Color:<\/td>\s*<td>(?<exterior_color>[^<]+)/',
        'price'          => '/<span class="inventoryList-bike-details-price ">(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(

        'vin'         => '/VIN number:<\/td>\s*<td>(?<vin>[^<]+)/',
        'description' => '/<meta property="og:description" content="(?<description>[^"]+)/',
    ),
    'next_query_regx'        => '/data-(?<param>page)="(?<value>[0-9]*)" title="Next page">/',
    'images_regx'            => '/data-lightbox-prevent href="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)/',
);
add_filter('filter_jamestowncanamseadoocom_car_data', 'filter_jamestowncanamseadoocom_car_data');

function filter_jamestowncanamseadoocom_car_data($car_data)
{
    $car_data['vin']            = md5($car_data['url']);
    $car_data['exterior_color'] = str_replace('&', 'and', $car_data['exterior_color']);
    $car_data['make']           = str_replace('®', '', $car_data['make']);
    $car_data['model']          = str_replace('®', '', $car_data['model']);
    $car_data['make']           = str_replace('Â', '', $car_data['make']);
    $car_data['model']          = str_replace('Â', '', $car_data['model']);
    return $car_data;
}
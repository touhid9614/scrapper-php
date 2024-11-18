<?php

global $scrapper_configs;
$scrapper_configs["harleyofdothancom"] = array(
    'entry_points' => array(
        'used' => 'https://harleyofdothan.com/inventory?condition=preowned',
        'new' => 'https://harleyofdothan.com/new-inventory',
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['#invUnitSliderTray .item > ul > li'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<ul id="inventoryBikesList"',
    'details_end_tag' => '<div class="list-pagination">',
    'details_spliter' => '<li class="inventoryList-bike">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock number:<\/td><td>(?<stock_number>[^<]+)/',
        //'stock_type'        => '/Condition:\s*(?<stock_type>[^"]+)/',
        'year' => '/Year:<\/td><td>(?<year>[^<]+)/',
       // 'make' => '/class="inventoryList-bike-details-title">[^>]+>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+)/',
       // 'model' => '/class="inventoryList-bike-details-title">[^>]+>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+)/',
        'url' => '/class="inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)"/',
        'price' => '/inventoryList-bike-details-price ">(?<price>[^<]+)/',
        'kilometres' => '/Mileage:<\/td><td>(?<kilometres>[^<]+)/',
        'exterior_color' => '/Color:<\/td><td>(?<exterior_color>[^<]+)/',
        'vin' => '/Stock number:<\/td><td>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'vin'   => '/VIN number:<\/td>\s*<td>(?<vin>[^<]+)/',
        'model' => '/inventoryModel-details-header">\s*<h1>(?<model>[^<]+)/',
        'make'  => '/class="mainHeader-title" href="\/">(?<make>[^<]+)/',
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" data-page="[0-9]+" title="Next page"/',
    'images_regx' => '/data-gallery="inventoryGallery" data-lightbox[^"]+"(?<img_url>[^"]+)"/',
);
add_filter('filter_harleyofdothancom_car_data', 'filter_harleyofdothancom_car_data');

function filter_harleyofdothancom_car_data($car_data) {
   
    //$car_data['make'] = "HARLEY-DAVIDSON";
    $car_data['model'] = str_replace("Harley-Davidson®", "", $car_data['model']);
    $car_data['model'] = preg_replace('/[0-9]{4}/', '', $car_data['model'], -1);
    $car_data['exterior_color'] = str_replace("&", "and", $car_data['exterior_color']);
    
    
    return $car_data;
}

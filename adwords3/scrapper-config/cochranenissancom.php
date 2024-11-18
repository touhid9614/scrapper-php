<?php

global $scrapper_configs;
$scrapper_configs["cochranenissancom"] = array(
    'entry_points'           => array(
        'new'  => 'https://cochranenissan.com/new-inventory/',
        'used' => 'https://cochranenissan.com/used-inventory/',
    ),
    'use-proxy'              => true,
    'refine'                 => false,
    'vdp_url_regex'          => '/\/view\//i',
    'details_start_tag'      => 'let inventory',
    'details_end_tag'        => 'class="pl-2 lbx_powered"',
    'details_spliter'        => '{"id',
    'data_capture_regx'      => array(
        'custom'       => '/\:(?<custom>[^\,]+)\,"time/',
        'custom1'      => '/"condition"\:"(?<custom1>[^"]+)/',
        'url'          => '/\:(?<url>[^\,]+)\,"time/',
        'year'         => '/"year"\:"(?<year>[^"]+)/',
        'make'         => '/"make"\:"(?<make>[^"]+)/',
        'model'        => '/"model"\:"(?<model>[^"]+)/',
        'stock_number' => '/"stocknumber"\:"(?<stock_number>[^"]+)/',
        'price'        => '/"saleprice"\:(?<price>[^\,]+)\,/',
        'vin'          => '/"vin"\:"(?<vin>[^"]+)/',
        'trim'         => '/"trim"\:"(?<trim>[^"]+)/',
        'custom2'      => '/"picture"\:"(?<custom2>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
    // 'images_regx'            => '/og:image" content="(?<img_url>[^"]+)/',
);

add_filter('filter_cochranenissancom_car_data', 'filter_cochranenissancom_car_data');
function filter_cochranenissancom_car_data($car_data)
{
    $car_data['url'] = "https://cochranenissan.com/view/{$car_data['custom1']}-{$car_data['year']}-{$car_data['make']}-{$car_data['model']}-{$car_data['custom']}/";

    
    $car_data['all_images'] = str_replace('\/', "/", $car_data['custom2']);

    return $car_data;
}
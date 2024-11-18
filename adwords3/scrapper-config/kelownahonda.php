<?php

global $scrapper_configs;

$scrapper_configs["kelownahonda"] = array(
    'entry_points'           => array(
        'used' => 'https://www.kelownapowersports.com/search/inventory/usage/Used',
        'new'  => 'https://www.kelownapowersports.com/search/inventory/usage/New/type/Street%20Bikes/type/ATV/type/Side%20x%20Side/type/Dirt%20Bikes/type/Cruiser~~V-Twin/type/Scooters',
    ),
    'vdp_url_regex'          => '/\/inventory\/[0-9]{4}\-/i',
    'srp_page_regex'         => '/search\/inventory\//i',

    'use-proxy'              => true,
    'proxy-area'             => 'CA',
    'refine'                 => false,
    'refine'                 => false,

    'details_start_tag'      => 'lass="ari-section header"',
    'details_end_tag'        => 'class="ari-section footer"',
    'details_spliter'        => 'class="panel panel-default search-result">',
    'data_capture_regx'      => array(
        'url' => '/fa-search-plus">[^>]+>[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<picture>\s*<source/',
        'stock_number'  => '/Stock #<\/strong>\s*.*\s*<td[^>]+>\s*(?<stock_number>[^<]+)/',
        'year' => '/data-model-year>(?<year>[0-9]{4})/',
        'make' => '/data-model-brand>(?<make>[^<]+)/',
        'model'  => '/data-model-name>(?<model>[^<]+)/',
        'custom' => '/data-model-name>(?<custom>[^<]+)/',
        'price' => '/itemprop="price">\s*(?<price>\$[0-9,]+)/',
        'body_style' => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
        'exterior_color' => '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',   
    ),
    'data_capture_regx_full' => array(
        'year'         => '/itemYear"\:(?<year>[^\,]+)\,"itemMake"\:"(?<make>[^"]+)"\,"itemModel"\:"(?<model>[^"]+)/i',
        'make'         => '/itemYear"\:(?<year>[^\,]+)\,"itemMake"\:"(?<make>[^"]+)"\,"itemModel"\:"(?<model>[^"]+)/i',
        'model'        => '/itemYear"\:(?<year>[^\,]+)\,"itemMake"\:"(?<make>[^"]+)"\,"itemModel"\:"(?<model>[^"]+)/i',
        'price'        => '/"unitprice":"(?<price>[^"]+)/i',
        'stock_number' => '/"stockNumber":"(?<stock_number>[^"]+)/i',
        'vin'          => '/vin:\s*\'(?<vin>[^\']+)/i',
    ),

    'next_page_regx'         => '/<a href="(?<next>[^"]+)"\s*aria\-label\="Next/',
    'images_regx'            => '/<a href="(?<img_url>[^"]+)"\s*class="zoom/',
); 

add_filter('filter_kelownahonda_car_data', 'filter_kelownahonda_car_data');

function filter_kelownahonda_car_data($car_data) {
    
    if(strlen($car_data['model'])>12){
        $arr_model = explode(" ",$car_data['model']);
        $car_data['model'] = $arr_model[0];
        if(strlen($car_data['model']) < 2){
            $car_data['model'] = $arr_model[0] . " " . $arr_model[1];
        }
    }
   
    if(strpos($car_data['body_style'],"Bike") || strpos($car_data['body_style'],"ruiser") ||strpos($car_data['body_style'],"ort Touring") || strpos($car_data['body_style'],"cooters"))
    {
        $car_data['body_style']="Bikes";
    }
    else if(strpos($car_data['body_style'],"x Side")){
        $car_data['body_style']="UTV";
    }
    else if($car_data['body_style']=='ATV'){
        $car_data['body_style']="ATV";
    }
    if(strpos($car_data['make'],"LL BRANDS")){
        return null;
    }
    return $car_data;
}

add_filter('filter_for_fb_kelownahonda', 'filter_for_fb_kelownahonda', 10, 2);

function filter_for_fb_kelownahonda($car_data, $feed_type)
{
    if (in_array($feed_type, ['aia', 'retargeting', 'carousel', 'fb_catalogue'])) {
        $car_data['model'] = $car_data['custom'];
    }

    return $car_data;
}

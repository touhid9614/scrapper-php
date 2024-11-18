<?php

global $scrapper_configs;

$scrapper_configs["liverpoolvolkswagencomau"] = array(
    "entry_points"           => array(
        'new'  => 'https://www.liverpoolvolkswagen.com.au/new-volkswagen-liverpool/',
        'used' => 'https://www.liverpoolvolkswagen.com.au/used-volkswagen-liverpool/?q=perpage%3A30',
        'all'  => 'https://www.liverpoolvolkswagen.com.au/all-stock/list/',
        
        'demo' => 'https://www.liverpoolvolkswagen.com.au/demo-volkswagen-liverpool/?q=perpage%3A30',
        
    ),

    'use-proxy'              => true,
    "refine"                 => false,
    'vdp_url_regex'          => '/\/(?:new|used|certified-used|demo|all-stock|used-volkswagen-liverpool)\/view\/[0-9]{4}-/i',

    'picture_selectors'      => ['.gallery-photo'],
    'picture_nexts'          => ['.glyphicon-chevron-right'],
    'picture_prevs'          => ['.glyphicon-chevron-left'],
    'details_start_tag' => '<div id="stockListCanvas"',
   'details_end_tag'        => '<footer class="footer default">',
    'details_spliter' => '<div class="col-sm-6 col-md-4 stock-item-col hidden-xs">',

    'data_capture_regx'      => array(
        'title'        => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year'         => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make'         => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'model'        => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'trim'         => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)(?<trim>[^<]+))/',
        'url'          => '/<a\s*href="(?<url>[^"]+)"\s*title="/',
        'price'        => '/<h2 class="price_stocklist stocklist-price ">\s*(?<price>\$[0-9,]+)/',
        'transmission' => '/Transmission<\/td>\s*<td>\s*(?<transmission>[^\n<]+)/',
        'kilometres'   => '/Odometer<\/td>\s*<td>\s*(?<kilometres>[^\s*]+)/',
    ),

    'data_capture_regx_full' => array(
        'stock_type'     => '/,"itemCondition":"(?<stock_type>[^"]+)","/',
        'engine'         => '/"vehicleEngine":"(?<engine>[^"]+)/',
        'exterior_color' => '/"color":"(?<exterior_color>[^"]+)/',
        'fuel_type'      => '/fuelType":\s*"(?<fuel_type>[^"]+)/',
        'stock_number'   => '/"sku":"(?<stock_number>[^"]+)/',
        'vin'            => '/"vehicleIdentificationNumber":"(?<vin>[^"]+)/',
        'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
        'drivetrain'     => '/driveWheelConfiguration":"(?<drivetrain>[^"]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)"><meta/',
    ),

    'next_page_regx'        => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx'            => '/<a class="enlarge-image" href="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);

add_filter('filter_liverpoolvolkswagencomau_car_data', 'filter_liverpoolvolkswagencomau_car_data');

function filter_liverpoolvolkswagencomau_car_data($car_data)
{
    if ($car_data['stock_type'] == 'demo') {
        $car_data['custom']     = "demo";
        $car_data['stock_type'] = "new";
    } else {
        $car_data['custom'] = $car_data['stock_type'];
    }

    $car_data['description'] = strip_tags(preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['description']));
    $car_data['description'] = str_replace("<", "", $car_data['description']);

    return $car_data;
}
<?php
global $scrapper_configs;
$scrapper_configs["mcgrathhyundailiverpoolcomau"] = array(
    "entry_points"           => array(
//        'all'  => 'https://www.mcgrathhyundailiverpool.com.au/all-stock/list',
        'used' => 'https://www.mcgrathhyundailiverpool.com.au/used-hyundai-liverpool/?q=perpage%3A30',
        'demo' => 'https://www.mcgrathhyundailiverpool.com.au/demo-hyundai-liverpool/',
        'new'  => 'https://www.mcgrathhyundailiverpool.com.au/new-hyundai-liverpool/hyundai/',
    ),
    'use-proxy'              => true,
    "refine"                 => false,

    'vdp_url_regex'          => '/\/(?:new|used|certified-used|demo|all-stock|used-hyundai-liverpool)\/view\/[0-9]{4}-/i',
    // 'required_params'        => ['q'],
    'picture_selectors'      => ['.gallery-photo'],
    'picture_nexts'          => ['.glyphicon-chevron-right'],
    'picture_prevs'          => ['.glyphicon-chevron-left'],

    'details_start_tag'      => '<div id="stockListCanvas"',
    'details_end_tag'        => '<footer class="footer default">',
    'details_spliter'        => '<div class="col-sm-6 col-md-4 stock-item-col hidden-xs">',

    'data_capture_regx'      => array(
        'stock_type'      => '/Type:<\/div><div class="wsefvalue">(?<stock_type>[^<]+)/i',
        'title'        => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'url'          => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year'         => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make'         => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'model'        => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'trim'         => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)(?<trim>[^<]+))/',
        'price'        => '/<h2 class="price_stocklist stocklist-price ">\s*(?<price>\$[0-9,]+)/',
        'transmission' => '/Transmission<\/td>\s*<td>\s*(?<transmission>[^\n<]+)/',
        'kilometres'   => '/Odometer<\/td>\s*<td>\s*(?<kilometres>[^\s*]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine'         => '/"vehicleEngine":"(?<engine>[^"]+)/',
        'exterior_color' => '/"color":"(?<exterior_color>[^"]+)/',
        'fuel_type'      => '/fuelType":\s*"(?<fuel_type>[^"]+)/',
        'stock_number'   => '/"sku":"(?<stock_number>[^"]+)/',
        'vin'            => '/"vehicleIdentificationNumber":"(?<vin>[^"]+)/',
        'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
        'drivetrain'     => '/driveWheelConfiguration":"(?<drivetrain>[^"]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)"></',
    ),
    'next_query_regx'        => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx'            => '/<a class="enlarge-image" href="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);

add_filter('filter_mcgrathhyundailiverpoolcomau_car_data', 'filter_mcgrathhyundailiverpoolcomau_car_data');

function filter_mcgrathhyundailiverpoolcomau_car_data($car_data)
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

function filter_for_fb_mcgrathhyundailiverpoolcomau($car_data) {
    return $car_data;
}

function filter_for_retargeting_mcgrathhyundailiverpoolcomau($car_data) {
    return $car_data;
}

function filter_for_marketplace_mcgrathhyundailiverpoolcomau($car_data) {
    return $car_data;
}

function filter_for_aia_mcgrathhyundailiverpoolcomau($car_data) {
    return $car_data;
}

function filter_for_lookalike_mcgrathhyundailiverpoolcomau($car_data) {
    return $car_data;
}
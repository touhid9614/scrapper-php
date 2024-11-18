<?php
global $scrapper_configs;
$scrapper_configs["wollongongmazdacomau"] = array(
    "entry_points"           => array(
        'used' => 'https://www.wollongongmazda.com.au/used-mazda-north-wollongong/list?q=condition:used',
        'new'  => 'https://www.wollongongmazda.com.au/new-mazda-for-sale-north-wollongong/list?q=({make:Mazda}),condition:new',
        'demo' => 'https://www.wollongongmazda.com.au/demo-mazda-north-wollongong/list?q=({make:Mazda}),condition:demo',

    ),
    'use-proxy'              => true,
    'vdp_url_regex'          => '/\/(?:new|used|certified-used|all-stock)-[^\/]+\/view\/[0-9]{4}-/i',

    'picture_selectors'      => ['div.visible-sm.visible-xs div.gallery-thumbs div.item img.lazyOwl'],
    'picture_nexts'          => ['div#gallery-carousel div.owl-controls.clickable div.owl-buttons div.owl-next'],
    'picture_prevs'          => ['div#gallery-carousel div.owl-controls.clickable div.owl-buttons div.owl-prev'],

    'details_start_tag'      => '<div id="stockListCanvas"',
    'details_end_tag'        => '<footer class="row main">',
    'details_spliter'        => '<div class="col-sm-6 col-md-4 stock-item-col hidden-xs">',

    'data_capture_regx'      => array(
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
        'description'    => '/<meta name="description" content="(?<description>[^"]+)"><meta/',
    ),
    'next_page_regx'        => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx'            => '/<a class="enlarge-image" href="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);

add_filter('filter_wollongongmazdacomau_car_data', 'filter_wollongongmazdacomau_car_data');

function filter_wollongongmazdacomau_car_data($car_data)
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

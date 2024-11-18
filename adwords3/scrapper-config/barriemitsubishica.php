<?php

global $scrapper_configs;

$scrapper_configs["barriemitsubishica"] = array(
    'entry_points'           => array(
        'used' => 'https://www.barriemitsubishi.ca/used/',
        'new'  => 'https://www.barriemitsubishi.ca/new/',
    ),
    'vdp_url_regex'          => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next.next-small'],
    'picture_prevs'          => ['.left.left-small'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<!-- Footer -->',
    'details_spliter'        => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span style/',
        'year'           => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\<]+)/',
        'model'          => '/itemprop=\'model\' notranslate>(?<model>[^\<]+)/',
        'trim'           => '/"trim":"(?<trim>[^"]+)"/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain'     => '/"driveTrain":"(?<drivetrain>[^"]+)/',
        'vin'            => '/itemprop="sku">(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'fuel_type'      => '/Fuel type:<\/td>[^>]+>\s*(?<fuel_type>[^<]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx'         => '/<li class="active"><a href="">.*<\/a><\/li>\s*<li><a href="(?<next>[^"]+)">/',
    'images_regx'            => '/onerror="imgError\(this\)\;" (?:data-src|src)="(?<img_url>[^"]+)/',
);

add_filter('filter_barriemitsubishica_car_data', 'filter_barriemitsubishica_car_data');

function filter_barriemitsubishica_car_data($car_data)
{
    $car_data['price']        = numarifyPrice($car_data['price']);
    $car_data['finance']      = round(($car_data['price'] * 0.03465 + $car_data['price']) / 182);   // 0.99 * 7 / 100 / 2
    $car_data['finance_term'] = 84;
    $car_data['finance_rate'] = .99;

    return $car_data;
}

// client don't want to see biweekly
// https://app.asana.com/0/0/1198204533450181/f
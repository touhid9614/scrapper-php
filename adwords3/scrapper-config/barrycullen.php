<?php

global $scrapper_configs;

$scrapper_configs['barrycullen'] = array(
    'entry_points'           => array(
        'used' => 'https://www.barrycullen.com/VehicleSearchResults?search=preowned',
        'new'  => 'https://www.barrycullen.com/VehicleSearchResults?search=new',
    ),

    'vdp_url_regex'          => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy'              => true,

    'picture_selectors'      => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'          => ['.arrow.single.next'],
    'picture_prevs'          => ['.arrow.single.prev'],

    'details_start_tag'      => '<ul each="cards">',
    'details_end_tag'        => '<div class="content" id="pageDisclaimer">',
    'details_spliter'        => '<div class="deck" each="cards">',

    'data_capture_regx'      => array(
        'year'           => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make'           => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model'          => '/itemprop="model">(?<model>[^<]+)/',
        'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim'           => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url'            => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission'   => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price'          => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'kilometres'     => '/Kilometers<\/span>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'drivetrain'     => '/Drive Wheels<\/span>[^>]+>(?<drivetrain>[^<]+)/',
        'vin'            => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
    ),

    'data_capture_regx_full' => array(
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        'kilometres'     => '/miles":"(?<kilometres>[^"]+)/',
        'stock_number'   => '/,"stockNumber":"(?<stock_number>[^"]+)",/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
        'vin'            => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^<]+)"/',
        'fuel_type'      => '/itemprop="fuelEfficiency"[^>]+>\s*<span itemprop="value">(?<fuel_type>[^<]+)/',
        'drivetrain'     => '/Drivetrain:\s*(?<drivetrain>[^\n]+)/',
    ),

    'next_page_regx'         => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx'            => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx'   => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/',
);


/*add_filter("filter_barrycullen_next_page", "filter_barrycullen_next_page", 10, 2);

function filter_barrycullen_next_page($next, $current_page)
{
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

add_filter('filter_barrycullen_car_data', 'filter_barrycullen_car_data');

function filter_barrycullen_car_data($car_data)
{
    $car_data['fuel_type'] = 'Gas';

    return $car_data;
}

add_filter("filter_barrycullen_field_images", "filter_barrycullen_field_images");

function filter_barrycullen_field_images($im_urls)
{
    if (count($im_urls) < 3) {
        return [];
    }

    return array_filter($im_urls, function ($im_url) {
        return !endsWith($im_url, 'deg01.jpg', 'deg02.jpg', 'deg03.jpg', 'deg04.jpg', 'deg05.jpg', 'deg06.jpg', 'deg07.jpg', 'deg08.jpg', 'deg09.jpg');
    });
}*/
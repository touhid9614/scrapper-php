<?php

global $scrapper_configs;

$scrapper_configs['brodheadsvillechevy'] = array(
    'entry_points' => array(
        'used' => 'http://www.brodheadsvillechevy.com/VehicleSearchResults?search=used',
        'new' => 'http://www.brodheadsvillechevy.com/VehicleSearchResults?search=new',
        
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'kilometres' => '/Miles<\/span>\s*.*\s*<span[^>]+>(?<kilometres>[^<]+)/',
        'vin'                => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
         'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        //'kilometres' => '/mileageRange":(?<kilometres>[^\,]+)/',
         'stock_number' => '/Stock Number<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'vin' => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
        'description' => '/Vehicle Description[^"]+"[^>]+>[^>]+>\s*<p>(?<description>[^<]+)/',
        'fuel_type' => '/itemprop="fuelEfficiency"[^>]+>\s*<span itemprop="value">(?<fuel_type>[^<]+)/',
        'drivetrain' => '/Engine<\/span>[^>]+>[^>]+>[^>]+>(?<drivetrain>[^<]+)/',
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_brodheadsvillechevy_next_page", "filter_brodheadsvillechevy_next_page", 10, 2);

function filter_brodheadsvillechevy_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

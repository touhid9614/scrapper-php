<?php

global $scrapper_configs;

$scrapper_configs['rimrockgm'] = array(
    'entry_points' => array(
        'new' => 'https://www.rimrockgm.com/VehicleSearchResults?search=new',
        'used' => 'https://www.rimrockgm.com/VehicleSearchResults?pageContext=VehicleSearch&search=used'
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
    'used-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'stock_number' => '/stockNumber:(?<stock_number>[^;]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'vin' => '/vin:(?<vin>[^;]+)/'
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_rimrockgm_next_page", "filter_rimrockgm_next_page", 10, 2);

function filter_rimrockgm_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

<?php

global $scrapper_configs;
$scrapper_configs["perryvwslo"] = array(
    'entry_points' => array(
        'new' => 'https://www.perryvwslo.com/VehicleSearchResults?&search=new',
        'used' => 'https://www.perryvwslo.com/VehicleSearchResults?&search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/'
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_perryvwslo_next_page", "filter_perryvwslo_next_page", 10, 2);

function filter_perryvwslo_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

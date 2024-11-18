<?php

global $scrapper_configs;

$scrapper_configs['westerngmdrumheller'] = array(
    'entry_points' => array(
        'new' => 'https://www.westerngmdrumheller.com/VehicleSearchResults?search=new',
        'used' => 'https://www.westerngmdrumheller.com/VehicleSearchResults?search=used',
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
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'vin' => '/vin:(?<vin>[^;]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock Number<\/span>\s*[^>]+>(?<stock_number>[^<]+)/',
        'vin' => '/vin:(?<vin>[^;]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/Engine<\/span>\s*<[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/'
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_westerngmdrumheller_next_page", "filter_westerngmdrumheller_next_page", 10, 2);

function filter_westerngmdrumheller_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

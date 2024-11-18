<?php

global $scrapper_configs;

$scrapper_configs['sullivancountygmcars'] = array(
    'entry_points' => array(
        'new' => 'https://www.mmbuickcadillac.com/VehicleSearchResults?search=new',
        'used' => 'https://www.mmbuickcadillac.com/VehicleSearchResults?search=preowned',
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
      'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/data-action="priceSpecification".*value="[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/Miles<\/span>\s*<[^>]+>\s*<span[^>]+>(?<kilometeres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
       
        
        
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_sullivancountygmcars_next_page", "filter_sullivancountygmcars_next_page", 10, 2);
//add_filter('filter_sullivancountygmcars_field_stock_number', 'filter_sullivancountygmcars_field_stock_number');

function filter_sullivancountygmcars_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

//function filter_sullivancountygmcars_field_stock_number($stock_number) {
//    if ($stock_number == 'N/A') {
//        $stock_number = '';
//    }
//    return $stock_number;
//}

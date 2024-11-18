<?php
global $scrapper_configs;
$scrapper_configs["bensonschevycom"] = array( 
	  'entry_points' => array(
        'new' => 'https://www.bensonschevy.com/VehicleSearchResults?search=new',
        'used' => 'https://www.bensonschevy.com/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}/i',
    'use-proxy' => true,
    'refine'=> false,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
       
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'stock_type' => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        //'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^>]+>\s*<[^>]+>(?<transmission>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'kilometres' => '/Kilometers<\/span>\s*<[^>]+>\s*<span[^>]+>(?<kilometeres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
          'vin'      => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'stock_number' => '/stockNumber":"(?<stock_number>[^"]+)/',
        'year' => '/data-year="(?<year>[0-9]{4})/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/"model":"(?<model>[^"]+)/',
      'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
      'transmission'      => '/itemprop="vehicleTransmission"[^>]+>\s*<[^>]+>(?<transmission>[^<]+)/',
      'exterior_color'    => '/Exterior Color<\/span>[^>]+>(?<exterior_color>[^<]+)/',
     'interior_color'    => '/Interior Color<\/span>[^>]+>(?<interior_color>[^<]+)/',
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_bensonschevycom_next_page", "filter_bensonschevycom_next_page", 10, 2);

function filter_bensonschevycom_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

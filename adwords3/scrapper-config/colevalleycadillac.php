<?php

global $scrapper_configs;
$scrapper_configs["colevalleycadillac"] = array(
    'entry_points' => array(
        'new' => 'http://www.colevalleycadillac.com/VehicleSearchResults?search=new',
        'used' => 'http://www.colevalleycadillac.com/VehicleSearchResults?search=preowned',
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
        'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'stock_number' => '/Stock Number<\/span>\s<span[^>]+>(?<stock_number>[^<]+)/',
        'year' => '/class="year"\s[^>]+>(?<year>[0-9]{4})/',
        'make' => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/class="model"\s[^>]+>(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/itemprop="price"\s.*data-action="priceSpecification"[^>]+>(?<price>[^<]+)/',
        'msrp'          => '/MSRP\s*<\/span>[^>]+>(?<msrp>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
    ),
    'next_page_regx' => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);


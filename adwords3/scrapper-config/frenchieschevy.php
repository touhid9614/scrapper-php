<?php

global $scrapper_configs;
$scrapper_configs["frenchieschevy"] = array(
    'entry_points' => array(
        'new' => 'https://www.frenchieschevy.com/VehicleSearchResults?search=new',
        'used' => 'https://www.frenchieschevy.com/VehicleSearchResults?search=preowned',
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
        'stock_number' => '/itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'stock_number' => '/Stock Number<\/span>\s*<span class="value" itemprop="sku">(?<stock_number>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior Color<\/span>[^>]+>(?<exterior_color>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/'
    ),
    'next_page_regx' => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_frenchieschevy_next_page", "filter_frenchieschevy_next_page", 10, 2);

function filter_frenchieschevy_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

add_filter("filter_frenchieschevy_field_images", "filter_frenchieschevy_field_images");
function filter_frenchieschevy_field_images($im_urls)
{

    $im_urls=  array_filter($im_urls,function($im_url){
        return !endsWith($im_url,"noImage_large.png") ;
    } );

    return $im_urls;
}

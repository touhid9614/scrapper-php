<?php

global $scrapper_configs;
$scrapper_configs["crosstownchev"] = array(
    'entry_points' => array(
        'new' => 'https://www.crosstownchev.ca/VehicleSearchResults?search=new',
        'used' => 'https://www.crosstownchev.ca/VehicleSearchResults?search=used',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\//i',
    'ty_url_regex' => '/\/thankYou.do/i',
    'ajax_url_match' => 'callback=secureLeadSubmission',
    'use-proxy' => true,
    'picture_selectors' => ['.img-thumbnail'],
    'picture_nexts' => ['.next'],
    'picture_prevs' => ['.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'stock_number' => '/vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a.*href="(?<next>[^"]+)"\s*rel="next">Next/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_crosstownchev_next_page", "filter_crosstownchev_next_page", 10, 2);

function filter_crosstownchev_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}


//add_filter("filter_crosstownchev_field_images", "filter_crosstownchev_field_images");
//    function filter_crosstownchev_field_images($im_urls)
//    {
//        if (count($im_urls) <= 2) {
//            return array();
//        }
//        if(count($im_urls) > 0) 
//        { 
//            unset($im_urls[0]); 
//            
//        }
//        return $im_urls;
//    }

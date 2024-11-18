<?php
global $scrapper_configs;
$scrapper_configs["superiorgmcalcom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.superiorgmcal.com/VehicleSearchResults?search=new',
        'used' => 'https://www.superiorgmcal.com/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="content" template="content"><div class="title"',
    'data_capture_regx' => array(
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine".*\s*[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_superiorgmcalcom_next_page", "filter_superiorgmcalcom_next_page", 10, 2);
add_filter("filter_superiorgmcalcom_field_images", "filter_superiorgmcalcom_field_images");

function filter_superiorgmcalcom_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

function filter_superiorgmcalcom_field_images($im_urls)
    {
        $retval = [];
        
        foreach($im_urls as $img)
        {
            $retval[] = str_replace('|', '%7c', $img);
        }
        
        return $retval;
    }




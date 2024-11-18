<?php
global $scrapper_configs;
 $scrapper_configs["sellersbuickgmccom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.sellersbuickgmc.com/VehicleSearchResults?search=new',
        'used' => 'https://www.sellersbuickgmc.com/VehicleSearchResults?search=preowned',
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
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/template="vehicleIdentitySpecs-stockNumber">[^>]+>Stock Number[^>]+>\s*<span class="value" itemprop="sku">(?<stock_number>[^<]+)/',
        'transmission' => '/template="vehicleIdentitySpecs-transmission"><span class="key">(?<transmission>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^<]+)/',
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_sellersbuickgmccom_next_page", "filter_sellersbuickgmccom_next_page", 10, 2);
add_filter("filter_sellersbuickgmccom_field_images", "filter_sellersbuickgmccom_field_images");
;

function filter_sellersbuickgmccom_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

function filter_sellersbuickgmccom_field_images($im_urls)
    {
        $retval = [];
        
        foreach($im_urls as $img)
        {
            $retval[] = str_replace('|', '%7c', $img);
        }
        
        return $retval;
    }


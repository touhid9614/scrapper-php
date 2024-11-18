<?php
global $scrapper_configs;
 $scrapper_configs["lakeshoremotorsltd"] = array( 
		'entry_points' => array(
		'new' => 'https://www.lakeshoremotorsltd.com/VehicleSearchResults?search=new',
		'used' => 'https://www.lakeshoremotorsltd.com/VehicleSearchResults?search=preowned',
	),
	'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
        'refine' =>false,
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
    ),
    'data_capture_regx_full' => array(
      
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^<]+)/',
    ),
     'next_page_regx'    => '/data-action="next" href="(?<next>[^"]+)"\s* rel="next">Next/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
   
);

add_filter("filter_lakeshoremotorsltd_next_page", "filter_lakeshoremotorsltd_next_page", 10, 2);

function filter_lakeshoremotorsltd_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}
 add_filter("filter_lakeshoremotorsltd_field_images", "filter_lakeshoremotorsltd_field_images");

function filter_lakeshoremotorsltd_field_images($im_urls) {
     if(count($im_urls) < 2) 
         {
         return array(); 
         
         }
     if(count($im_urls) > 0) 
        { 
            unset($im_urls[0]); 
            
        }
        return $im_urls;
}

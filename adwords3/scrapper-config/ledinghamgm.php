<?php
global $scrapper_configs;
 $scrapper_configs["ledinghamgm"] = array( 
	'entry_points' => array(
		'new' => 'https://www.ledinghamgm.com/VehicleSearchResults?search=new',
		'used' => 'https://www.ledinghamgm.com/VehicleSearchResults?search=preowned',
	),
	'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
       'refine' => false,
	'use-proxy' => true,
	'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
	'picture_nexts' => ['.arrow.single.next'],
	'picture_prevs' => ['.arrow.single.prev'],

	'details_start_tag' => '<ul each="cards">',
	'details_end_tag' => '<div class="content" id="pageDisclaimer">',
	'details_spliter' => '<div class="deck" each="cards">',

	'data_capture_regx' => array(
		'stock_type' => '/itemprop="itemCondition">(?<stock_type>[^<]+)/',
		'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
		'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
		'model' => '/itemprop="model">(?<model>[^<]+)/',
		'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',	
		'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
	),
	'data_capture_regx_full' => array(
		'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
		'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
                'stock_number' => '/Stock Number<\/span>[^>]+>(?<stock_number>[^<]+)/',
		'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
		'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
		'model' => '/itemprop="model">(?<model>[^<]+)/',
		'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
		'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
		'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
		'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
                'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/',
     
	),
	'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
	'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_ledinghamgm_next_page", "filter_ledinghamgm_next_page", 10, 2);
   add_filter("filter_ledinghamgm_field_stock_type", "filter_ledinghamgm_field_stock_type");

function filter_ledinghamgm_next_page($next, $current_page)
{
	slecho("Filtering Next url");
	$car_type = explode('=', $current_page);
	return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}
   

    function filter_ledinghamgm_field_stock_type($stock_type) {
        return strtolower($stock_type);
    }
    
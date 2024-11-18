<?php
global $scrapper_configs;
$scrapper_configs["butlergmcom"] = array( 
	"entry_points" => array(
		'used' => 'https://www.butlergm.com/VehicleSearchResults?search=preowned',
        'new' =>  'https://www.butlergm.com/VehicleSearchResults?search=new',
		
	),
	'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
	'used-proxy' => true,
	'refine' => false,
	'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
	'picture_nexts' => ['.arrow.single.next'],
	'picture_prevs' => ['.arrow.single.prev'],

	'details_start_tag' => '<ul each="cards">',
	'details_end_tag' => '<div class="content" id="pageDisclaimer">',
	'details_spliter' => '<div class="deck" each="cards">',
	'data_capture_regx' => array(
		'url'               => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
		'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
		'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
		'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
		'model'             => '/itemprop="model">(?<model>[^<]+)/',
		'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
		'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
		'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
		'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
	),
	'data_capture_regx_full' => array(
		'stock_number'      => '/"stockNumber":"(?<stock_number>[^"]+)/',
	    'vin' => '/"vin":"(?<vin>[^"]+)/',
       'drivetrain' => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
       'description' => '/<meta property="og:description" content="(?<description>[^"]+)/',
		'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/', 	
		'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
		'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/',
	),
	'next_page_regx'        => '/data-action="next" href="(?<next>[^"]+)"/',
	'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
	'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/',
);


add_filter("filter_butlergmcom_next_page", "filter_butlergmcom_next_page", 10, 2);

function filter_butlergmcom_next_page($next, $current_page)
{
	slecho("Filtering Next url");
	$car_type = explode('=', $current_page);
	return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}
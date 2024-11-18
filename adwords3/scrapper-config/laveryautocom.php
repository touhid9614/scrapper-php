<?php
global $scrapper_configs;
$scrapper_configs["laveryautocom"] = array( 
	"entry_points" => array(
		'new' => 'https://www.laveryauto.com/VehicleSearchResults?search=new',
		'used' => 'https://www.laveryauto.com/VehicleSearchResults?search=preowned',
	),
	'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

	'use-proxy' => true,
	'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
	'picture_nexts' => ['.arrow.single.next'],
	'picture_prevs' => ['.arrow.single.prev'],

	'details_start_tag' => '<ul each="cards">',
	'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
	'details_spliter'   => '<div class="deck" each="cards">',

	 'data_capture_regx' => array(
           'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',
           'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
           'url'               => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
           'price'             => '/data-action="priceSpecification" [^>]+>(?<price>\$[0-9,]+)/',
       ),
       'data_capture_regx_full' => array(
           'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
           
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
           'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/'


       ),
    'next_page_regx'        => '/data-action="next" href="(?<next>[^"]+)"/',
	'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
	'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/',
);
    add_filter("filter_laveryautocom_next_page", "filter_laveryautocom_next_page",10,2);
    
    function filter_laveryautocom_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }



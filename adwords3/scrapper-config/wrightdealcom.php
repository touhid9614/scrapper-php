<?php
global $scrapper_configs;
$scrapper_configs["wrightdealcom"] = array( 
	"entry_points" => array(
	        'new'  => 'https://www.wrightdeal.com/VehicleSearchResults?search=new',
            'used' => 'https://www.wrightdeal.com/VehicleSearchResults?search=preowned',
        
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],

    'details_start_tag'    => '<ul each="cards">',
       'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
       'details_spliter'   => '<div class="deck" each="cards">',

        'data_capture_regx' => array(
      
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/', 
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock Number[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
        'vin' => '/"vin":"(?<vin>[^"]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^<]+)/',
        'kilometres'    => '/Miles[^>]+>\s*[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
    ),
        'next_page_regx'    => '/data-action="next" href="(?<next>[^"]+)"\s* rel="next">Next/',
       'images_regx'        => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
   );
    
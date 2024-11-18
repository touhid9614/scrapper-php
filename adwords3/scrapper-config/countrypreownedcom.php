<?php
global $scrapper_configs;
$scrapper_configs["countrypreownedcom"] = array( 
	'entry_points' => array(
   
        'used' => 'https://www.countrypreowned.com/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.co-lazy-loaded'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],

    'details_start_tag'    => '<ul each="cards">',
       'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
       'details_spliter'   => '<div class="deck" each="cards">',

       'data_capture_regx' => array(
           'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
          // 'vin'              => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',
           'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
          'price'             => '/itemprop="price".*data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
            'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
          // 'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
          
           'kilometres'        => '/Miles<\/span>\s*.*\s*[^>]+>(?<kilometeres>[^<]+)/',       
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
       ),
      'next_page_regx'        => '/data-action="next" href="(?<next>[^"]+)"/',
       'images_regx'        => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
   );
    
     add_filter("filter_countrypreownedcom_next_page", "filter_countrypreownedcom_next_page",10,2);
     
     
    function filter_countrypreownedcom_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    
    

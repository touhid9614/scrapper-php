<?php
global $scrapper_configs;
$scrapper_configs["auffenbergfarmingtoncom"] = array( 
	"entry_points" => array(
	   
        'new'  => 'https://www.auffenbergfarmington.com/VehicleSearchResults?search=new',
        'used' => 'https://www.auffenbergfarmington.com/VehicleSearchResults?search=preowned',
     
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

    'use-proxy' => true,
   
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
     'details_start_tag' => '<ul each="cards">',
     'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
     'details_spliter'   => '<div class="deck" each="cards">',
     'data_capture_regx' => array(
                
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',  
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',  
           'url'               => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
           'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
            'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/', 
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
           'engine'            => '/itemprop="vehicleEngine".*\s*[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
           'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
           'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/'


       ),
         'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)/',
        'images_regx'           => '/<meta itemprop="image" content="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
    add_filter("filter_auffenbergfarmingtoncom_next_page", "filter_auffenbergfarmingtoncom_next_page",10,2);
    
    function filter_auffenbergfarmingtoncom_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }

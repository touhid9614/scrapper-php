<?php
global $scrapper_configs;
 $scrapper_configs["tedfordchevrolet"] = array( 
	
   'entry_points' => array(
        'new'  => 'http://www.tedfordchevrolet.com/VehicleSearchResults?search=new',
        'used' => 'http://www.tedfordchevrolet.com/VehicleSearchResults?search=preowned',
       // 'certified' => 'http://www.tedfordchevrolet.com/VehicleSearchResults?search=certified',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/',
   

     'use-proxy' => true,
   //  'proxy-area'        => 'FL',
     'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
     'picture_nexts'     => ['.arrow.single.next'],
     'picture_prevs'     => ['.arrow.single.prev'],
    
     'details_start_tag'    => '<ul each="cards">',
        'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
        'details_spliter'   => '<div class="deck" each="cards">',
        
       'data_capture_regx' => array(
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'url'            => '/<a itemprop="url" href="(?<url>[^"]+)/',
//        'stock_type'     => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year'           => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make'           => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model'          => '/itemprop="model">(?<model>[^<]+)/',
        'price'          => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        //'interior_color' => '/<dd itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim'           => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
             'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
           'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/',
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/'

    ),
        'next_page_regx'        => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
    );
    
     add_filter("filter_tedfordchevrolet_next_page", "filter_tedfordchevrolet_next_page",10,2);
     
     
    function filter_tedfordchevrolet_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    
    
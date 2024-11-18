<?php
    global $scrapper_configs;

    $scrapper_configs['unitymotors'] = array(
      'entry_points' => array(
        'new'  => 'https://www.unitymotors.com/VehicleSearchResults?search=new',
        'used' => 'https://www.unitymotors.com/VehicleSearchResults?search=preowned'
      
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used)-[0-9]{4}-\S+/i',

     'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
     'details_start_tag' => '<ul each="cards">',
     'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
     'details_spliter'   => '<div class="deck" each="cards">',
    
      'data_capture_regx' => array(
           'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
           // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',
           'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
           'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
           'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
           'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
           'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/',
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/'


       ),
       'next_page_regx'        => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
    add_filter("filter_unitymotors_next_page", "filter_unitymotors_next_page",10,2);
    
    function filter_unitymotors_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }

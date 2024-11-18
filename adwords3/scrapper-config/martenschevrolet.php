<?php
global $scrapper_configs;

$scrapper_configs['martenschevrolet'] = array(
    'entry_points' => array(
        'new'  => 'http://www.martenschevrolet.com/VehicleSearchResults?search=new',
        'used' => 'http://www.martenschevrolet.com/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/',

     'use-proxy' => true,
     'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
     'picture_nexts'     => ['.arrow.single.next'],
     'picture_prevs'     => ['.arrow.single.prev'],
    
     'details_start_tag'    => '<ul each="cards">',
    'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
    'details_spliter'   => '<div class="deck" each="cards">',

    'data_capture_regx' => array(
        'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
        // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year'              => '/<span itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make'              => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
        'model'             => '/<span itemprop="model">(?<model>[^<]+)/',
        'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'interior_color'    => '/itemprop="vehicleInteriorColor" class="value">(?<interior_color>[^<]+)/',
        'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price'             => '/itemprop="price" data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
            'kilometres'    => '/not="isNumeric" class="value">(?<kilometeres>[^<]+)/',
            'certified'     =>'/"vehicle":\{"category":"(?<certified>certified)/',
             'body_style'   => '/"bodyType":"(?<body_style>[^"]+)/',
            
        ),
         'next_page_regx'    => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'       => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    );
    
     add_filter("filter_martenschevrolet_next_page", "filter_martenschevrolet_next_page",10,2);
     
     
    function filter_martenschevrolet_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    
    
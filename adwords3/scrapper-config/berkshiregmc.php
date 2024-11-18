<?php
global $scrapper_configs;

$scrapper_configs['berkshiregmc'] = array(
    'entry_points' => array(
        'new'  => 'https://www.berkshiregmc.com/VehicleSearchResults?search=new',
        'used' => 'https://www.berkshiregmc.com/VehicleSearchResults?search=preowned',
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
        'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'price'             => '/itemprop="price" data-action="priceSpecification" [^>]+>(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres'     => '/not="isNumeric" class="value">(?<kilometeres>[^<]+)/',
        'certified'      =>'/"vehicle":\{"category":"(?<certified>certified)/',
        'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/<span itemprop="color">(?<exterior_color>[^<]+)/',
        'interior_color' => '/<span itemprop="vehicleInteriorColor" class="value">(?<interior_color>[^<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
    ),
    'next_page_regx'    => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
    'images_regx'       => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    );
    
     add_filter("filter_berkshiregmc_next_page", "filter_berkshiregmc_next_page",10,2);
     
     
    function filter_berkshiregmc_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    
    
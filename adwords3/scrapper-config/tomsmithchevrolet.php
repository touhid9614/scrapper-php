<?php
global $scrapper_configs;

$scrapper_configs['tomsmithchevrolet'] = array(
    'entry_points' => array(
        'new'  => 'http://www.tomsmithchevrolet.ca/VehicleSearchResults?search=new',
        'used' => 'http://www.tomsmithchevrolet.ca/VehicleSearchResults?search=used',
        'certified' => 'http://www.tomsmithchevrolet.ca/VehicleSearchResults?search=certified',
      
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
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'url'            => '/<a itemprop="url" href="(?<url>[^"]+)/',
//        'stock_type'     => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year'           => '/<span itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make'           => '/<span.* itemprop="manufacturer">(?<make>[^<]+)/',
        'model'          => '/<span itemprop="model">(?<model>[^<]+)/',
        'price'          => '/itemprop="price" data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim'           => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres'        =>'/"miles":"(?<kilometres>[^"]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
    ),
        'next_page_regx'        => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
    add_filter("filter_tomsmithchevrolet_next_page", "filter_tomsmithchevrolet_next_page",10,2);
    
    function filter_tomsmithchevrolet_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
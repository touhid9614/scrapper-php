<?php
global $scrapper_configs;

$scrapper_configs['louisochs']  =  array(
    'entry_points'              => array(
        'new'                   => 'http://www.louisochs.com/VehicleSearchResults?search=new',
        'used'                  => 'http://www.louisochs.com/VehicleSearchResults?search=preowned'
    ),

    'vdp_url_regex'             => '/\/VehicleDetails\/(?:new|used)-[0-9]{4}-\S+/i',

    'use-proxy'                 => true,

    'picture_selectors'         => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'             => ['.arrow.single.next'],
    'picture_prevs'             => ['.arrow.single.prev'],

    'details_start_tag'         => '<ul each="cards">',
    'details_end_tag'           => '<div class="content" id="pageDisclaimer">',
    'details_spliter'           => '<div class="deck" each="cards">',

    'data_capture_regx'         => array(
        'stock_number'          => '/sku">(?<stock_number>[^<]+)/',
        'url'                   => '/subject[^=]+="url" href="(?<url>[^"]+)/',
        'stock_type'            => '/subject[^=]+="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year'                  => '/vehicleModelDate">(?<year>[0-9]{4})/',
        'make'                  => '/manufacturer">(?<make>[^<]+)/',
        'model'                 => '/model">(?<model>[^<]+)/',
        'price'                 => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'exterior_color'        => '/color">(?<exterior_color>[^<]+)/',
        'interior_color'        => '/vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'engine'                => '/vehicleEngine"[^\-]+[^=]+[^>]+>(?<engine>[^<]+)/',
        'trim'                  => '/class="trim"[^>]+>(?<trim>[^<]+)/',
    ),

    'data_capture_regx_full'    => array(
        'transmission'          => '/vehicleTransmission">(?<transmission>[^<]+)/',
        'body_style'            => '/"bodyType":"(?<body_style>[^"]+)/',
        'kilometres'            => '/"miles":"(?<kilometres>[^"]+)/',
        'certified'             => '/"vehicle":\{"category":"(?<certified>certified)/',
    ),

    'next_page_regx'            => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
    'images_regx'               => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx'      => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

    add_filter("filter_louisochs_next_page", "filter_louisochs_next_page",10,2);
    
    function filter_louisochs_next_page($next,$current_page) 
    {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
<?php
global $scrapper_configs;

$scrapper_configs['texarkanachevrolet'] = array(
    'entry_points'          => array(
        'new'               => 'http://www.texarkanachevrolet.com/VehicleSearchResults?search=new',
        'used'              => 'http://www.texarkanachevrolet.com/VehicleSearchResults?search=preowned',
     
    ),

    'vdp_url_regex'         => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy'             => true,
    'refine'=>false, 
    'picture_selectors'     => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'         => ['.arrow.single.next'],
    'picture_prevs'         => ['.arrow.single.prev'],
    
    'details_start_tag'     => '<ul each="cards">',
    'details_end_tag'       => '<div class="content" id="pageDisclaimer">',
    'details_spliter'       => '<div class="deck" each="cards">',

    'data_capture_regx'     => array(
        'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'url'               => '/subject[^=]+="url" href="(?<url>[^"]+)/',
        'stock_type'        => '/subject[^=]+="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model'             => '/itemprop="model">(?<model>[^<]+)/',
        'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'engine'            => '/itemprop="vehicleEngine"[^\-]+[^"]+[^>]+>(?<engine>[^<]+)/',
        'trim'              => '/class="trim"[^>]+>(?<trim>[^<]+)/'
    ),

    'data_capture_regx_full'=> array(
        'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
      //  'certified'         => '/"vehicle":\{"category":"(?<certified>certified)/'
    ),

     'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)/',
    'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

    add_filter("filter_texarkanachevrolet_next_page", "filter_texarkanachevrolet_next_page",10,2);
    
    function filter_texarkanachevrolet_next_page($next,$current_page) 
    {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
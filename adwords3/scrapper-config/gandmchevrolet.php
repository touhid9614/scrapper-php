<?php
    global $scrapper_configs;

    $scrapper_configs['gandmchevrolet'] = array(
        'entry_points' => array(
            'new'   => 'https://www.gandmchevrolet.ca/VehicleSearchResults?search=new',
            'used'  => 'https://www.gandmchevrolet.ca/VehicleSearchResults?search=preowned'
        ),
        'vdp_url_regex'     => '/\/VehicleDetails\//i',
        'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'context=leadSubmission',
        'use-proxy'         => true,
        
        'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
        'picture_nexts'     => ['.arrow.single.next'],
        'picture_prevs'     => ['.arrow.single.prev'],

        
        'details_start_tag' => '<ul each="cards">',
        'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
        'details_spliter'   => '<div class="deck" each="cards">',
        'data_capture_regx' => array(
            'stock_number'      => '/itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
            'year'              => '/<span .*itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
            'make'              => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
            'model'             => '/<span .*itemprop="model">(?<model>[^<]+)/',
            'price'             => '/itemprop="price".*data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
            'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
            'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
            'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',  
            'kilometres'        => '/Kilometers<\/span>[^>]+>[^>]+>(?<kilometeres>[^<]+)/',
            'interior_color'    => '/Interior<\/span>\s*.*itemprop="vehicleInteriorColor">(?<interior>[^<]+)/', 
        ),
        'data_capture_regx_full' => array(
             
        ) ,
        'next_page_regx'    => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'       => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
    );
 
    add_filter("filter_gandmchevrolet_next_page", "filter_gandmchevrolet_next_page",10,2);   
    function filter_gandmchevrolet_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
     }
    
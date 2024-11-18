<?php
    global $scrapper_configs;

    $scrapper_configs['classicchevyonline'] = array(
        'entry_points' => array(
            'new'   => 'http://www.classicchevymi.com/VehicleSearchResults?search=new',
            'used'  => 'http://www.classicchevymi.com/VehicleSearchResults?search=preowned'
       ),
        'vdp_url_regex'     => '/\/VehicleDetails\//i',
        //'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy'         => true,
        'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
        'picture_nexts'     => ['.arrow.single.next'],
        'picture_prevs'     => ['.arrow.single.prev'],
        'details_start_tag' => '<ul each="cards">',
        'details_end_tag'   => '<footer id="',
        'details_spliter'   => '<div class="deck" each="cards">',
        'data_capture_regx' => array(
            'stock_number'      => '/<dd itemprop="sku">(?<stock_number>[^<]+)/',
            'year'              => '/<span itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
            'make'              => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
            'model'             => '/<span itemprop="model">(?<model>[^<]+)/',
            'engine'            => '/<dd itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
            'kilometres'        => '/itemprop="mileageFromOdometer">(?<kilometres>[^<]+)/',
            'exterior_color'    => '/<dd itemprop="color">(?<exterior_color>[^<]+)/',
            'interior_color'    => '/<dd itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
           // 'original'          => '/<span>\*<\/span>\s*<[^\s]+\s*<[^\s]+\s*<span\s*itemprop="price"[^>]+>(?<original>[^<]+)/',
        //    'price'             => '/<span>\*\*<\/span>\s*<[^\s]+\s*<[^\s]+\s*<span\s*itemprop="price"[^>]+>(?<price>[^<]+)/',
            'price'             => '/itemprop="price" data-action="priceSpecification"[^>]+>(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'transmission'      => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
            'certified'         => '/<img.*alt="(?<certified>certified)/'

        ) ,
        'next_page_regx'    => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'       => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'   => '/<meta\s*if="[^"]+"\s*property="og:image"\s*content="(?<img_url>[^"]+)/'
    );
   
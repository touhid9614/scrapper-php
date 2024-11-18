<?php
    global $scrapper_configs;

    $scrapper_configs['dalewarnickchevrolet'] = array(
        'entry_points' => array(
            'new'   => 'http://www.dalewarnickchevrolet.com/VehicleSearchResults?search=new',
            'used'  => 'http://www.dalewarnickchevrolet.com/VehicleSearchResults?search=preowned'
       ),
        'vdp_url_regex'     => '/\/VehicleDetails\//i',
        //'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy'         => true,
        
        'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
        'picture_nexts'     => ['.arrow.single.next'],
        'picture_prevs'     => ['.arrow.single.prev'],
        
        'details_start_tag' => '<ul each="cards">',
        'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
        'details_spliter'   => '<div class="deck" each="cards">',
        'data_capture_regx' => array(
            'stock_number'      => '/<dd itemprop="sku">(?<stock_number>[^<]+)/',
            // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
            'year'              => '/<span itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
            'make'              => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
            'model'             => '/<span itemprop="model">(?<model>[^<]+)/',
            'engine'            => '/<dd itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
            //'body_style'        => '/<dd .*itemprop="bodyType"[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
            'transmission'      => '/<dd itemprop="vehicleTransmission"[^>]+>\s*<[^>]+>(?<transmission>[^<]+)/',
            //'kilometres'        => '/itemprop="mileageFromOdometer">(?<kilometres>[^<]+)/',
            'exterior_color'    => '/<dd itemprop="color">(?<exterior_color>[^<]+)/',
            'interior_color'    => '/<dd itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
            'price'             => '/itemprop="price" data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',

        ),
        'data_capture_regx_full' => array(
            'kilometres'        =>'/"miles":"(?<kilometres>[^"]+)/',
            'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/'
        ) ,
        'next_page_regx'    => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'       => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'   => '/<meta\s*if="[^"]+"\s*property="og:image"\s*content="(?<img_url>[^"]+)/'
    );
    add_filter("filter_dalewarnickchevrolet_next_page", "filter_dalewarnickchevrolet_next_page",10,2);
    add_filter("filter_dalewarnickchevrolet_field_images", "filter_dalewarnickchevrolet_field_images");
    
    
    function filter_dalewarnickchevrolet_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    function filter_dalewarnickchevrolet_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image_graphic.gif');
        });
    }
    


<?php
    global $scrapper_configs;

    $scrapper_configs['phillongkia'] = array(
        'entry_points' => array(
            'new'   => 'http://www.phillongkia.com/search/new/tp/',
            'used'  => 'http://www.phillongkia.com/search/used/tp/'
        ),
        'vdp_url_regex'     => '/\/[^\/]+\/(?:new|used)-[0-9]{4}-/i',
//        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'use-proxy' => true,
        'proxy-area'        => 'FL',
        'picture_selectors' => ['.dep_image_slider_ul_style li'],
        'picture_nexts'     => ['.dep_image_slider_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_prev_btn'],
        
        'details_start_tag' => '<div class="srp_results"',
        'details_end_tag'   => '<div id="details-disclaimer" class=\'thm-general_border\'>',
        'details_spliter'   => '<div class="srp_vehicle_item_container srp_vehicle_table"',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)" \/>/',
            'title'         => '/<h2>\s*<a\s*href="(?<url>[^"]+)".*title="(?<title>[^"]+)"/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)" \/>/',
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)" \/>/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)" \/>/',
            'price'         => '/<meta itemprop="price" content="(?<price>[^"]+)" \/>/',
           // 'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
//            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'transmission'  => '/<meta itemprop="vehicleTransmission" content="(?<transmission>[^"]+)" \/>/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)" \/>/',
            'interior_color'=> '/<meta itemprop="vehicleInteriorColor" content="(?<interior_color>[^"]+)" \/>/',
            'kilometres'    => '/Mileage:<\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/<h2>\s*<a\s*href="(?<url>[^"]+)".*title="(?<title>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine<\/td>\s*<td[^>]+>(?<engine>[^<]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)" \/>/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)" \/>/',
            'trim'          => '/Trim<\/td>\s*<td[^>]+>(?<trim>[^<]+)/',
            
            
        ),
        'next_page_regx'       => '/<li\s*class="active[^>]+>.*<\/li>\s*<li[^>]+>\s*<a class="[^"]+"\s*href="(?<next>[^"]+)/',
        'images_regx'          => '/<\/div>\s*<meta itemprop="image"\s*content="(?<img_url>[^"]+)"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    

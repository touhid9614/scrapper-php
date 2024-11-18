<?php
    global $scrapper_configs;

    $scrapper_configs['rudatoyota'] = array(
        'entry_points' => array(
            'new'   => 'https://www.rudatoyota.com/search/monroe-wi/?tp=new&cy=53566',
            'used'  => 'https://www.rudatoyota.com/search/monroe-wi/?tp=used&cy=53566'
        ),
        'vdp_url_regex'     => '/\/vehicle-details/i',
//        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<div class="srp_orderby_select_container">',
        'details_end_tag'   => '<div id="details-disclaimer"',
        'details_spliter'   => '<div class="srp_vehicle_wrapper',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #<\/td>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/multi_widget[^>]+><h2><a href="[^"]+" alt="[^"]+" title="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/<meta itemprop="price" content="(?<price>[^"]+)/',
            'transmission'  => '/<meta itemprop="vehicleTransmission" content="(?<transmission>[^"]+)" \/>/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'interior_color'=> '/<meta itemprop="vehicleInteriorColor" content="(?<interior_color>[^"]+)/',
            'url'           => '/multi_widget[^>]+><h2><a href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine<\/td>\s*[^>]+>(?<engine>[^<]+)/',
           // 'interior_color'=> '/Interior:<\/strong><\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',
            //'transmission'  => '/Transmission:<\/strong><\/span>\s*<span[^>]+>(?<transmission>[^<]+)/',
           // 'body_style'    => '/Body:<\/strong><\/span>\s*<span[^>]+>(?<body_style>[^<]+)/',
           // 'model'         => '/Model:<\/strong><\/span>\s*<span[^>]+>(?<model>[^<]+)/',
            //'trim'          => '/Trim:<\/strong><\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/>Mileage<\/td>\s*[^>]+>(?<kilometres>[^<]+)/',
            //'certified'     => '/<img src="[^"]+" alt="(?<certified>Certified)"/',
            
            
        ),
        'next_page_regx'       => '/class="next">\s*<a class="[^"]+" href="(?<next>[^"]+)/',
        'images_regx'          => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    
//   add_filter("filter_bobbsaysyes_field_engine", "filter_bobbsaysyes_field_engine");
//
//
//function filter_bobbsaysyes_field_engine($engine) {
//    return str_replace('/', '&#47', $engine);
//}



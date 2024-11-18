<?php

    global $scrapper_configs;

    $scrapper_configs['sherwoodchev'] = array(
        'entry_points' => array(
            'new'   => 'http://www.sherwoodchev.com/VehicleSearchResults?search=new',
            'used'  => 'http://www.sherwoodchev.com/VehicleSearchResults?search=used'
        ),
        'vdp_url_regex'     => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
        //'ty_url_regex'      => '/\/contact-form-confirm/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
        'details_start_tag' => '<div class="deck" each="cards">',
        'details_end_tag'   => '<div role="navigation">',
        'details_spliter'   => '<!--^_^-->',
        'data_capture_regx' => array(
            'url'                 => '/<a\sitemprop="url"\shref="(?<url>[^"]+)/',
            'title'               => '/<a\sitemprop="url"\shref="[^\/]+\/\/[^\/]+\/[^\/]+\/(?<title>[^\/]+)/',
            'year'                => '/<a\sitemprop="url"\shref="[^-]+-(?<year>[0-9]{4})\s*/',
            'make'                => '/<a\sitemprop="url"\shref="[^-]+-[0-9]{4}-(?<make>[^-]+)/',
            'model'               => '/<a\sitemprop="url"\shref="[^-]+-[0-9]{4}-[^-]+-(?<model>[^-]+)/',
            'price'               => '/Sherwood Price\n\s*</span>\n\s*[^>]+>\n\s*<span[^>]+>(?<price>\$[^<]+)/',
            'stock_number'        => '/<span class="key">Stock Number[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'engine'              => '/<span class="key">Engine[^>]+>[^>]+>\n.*\n\s*<span[^>]+>(?<engine>[^<]+)/',
            'kilometres'          => '/<span class="key">Kilometers[^>]+>[^>]+>\n<span[^>]+>(?<kilometers>[^<]+)/',
            //'body_style'          => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'transmission'        => '/<span class="key">Transmission[^>]+>[^>]+>\n\s*<span[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'      => '/<span class="key">Exterior[^>]+>\n<span[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'      => '/<span class="key">Interior[^>]+>\n<span[^>]+>(?<interior_color>[^<]+)/',
            //'certified'           => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/'
        ),
        'data_capture_regx_full' => array(  
            'make'                => '/make:(?<make>[^;]+);/',
            'model'               => '/model:(?<model>[^;]+);/',
           
            
        ) ,
        'next_page_regx'    => '/<a\s*if="[^"]+"\s*data-action="next"\s*href="(?<next>[^"]+)"/',
        'images_regx'       => '/<img itemprop="associatedMedia" src="(?<img_url>[^"]+)"\s*/'
    );
    

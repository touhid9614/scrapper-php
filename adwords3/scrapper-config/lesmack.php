<?php
    global $scrapper_configs;

    $scrapper_configs['lesmack'] = array(
        'entry_points' => array(
            'new'   => 'http://www.lesmack.com/new-inventory',
            'used'  => 'http://www.lesmack.com/used-inventory'
        ),
        'vdp_url_regex'     => '/inventory\/details\/(?:new|used)\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
        'use-proxy' => true,
        
        'picture_selectors' => ['.fotorama__thumb.fotorama__loaded'],
        'picture_nexts'     => ['.fotorama__arr--next'],
        'picture_prevs'     => ['.fotorama__arr--prev'],
        
        'details_start_tag' => '<div class="block-grid-xl-4',
        'details_end_tag'   => '<div class="col-md-9 col-md-push-3">',
        'details_spliter'   => '<div class="block-grid-item"',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock Number<\/strong>\s*<\/td>\s*<td>\s*(?<stock_number>[^<]+)/',
            'year'          => '/result-year\'>(?<year>[0-9]{4})/',
            'make'          => '/result-make\'>(?<make>[^<]+)/',
            'model'         => '/result-model\'>(?<model>[^<]+)/',
            'trim'          => '/result-package">(?<trim>[^<]+)/',
            'price'         => '/Les Mack Price<\/span>\s*<span class="price">\s*(?<price>\$[0-9,.]+)/',
            'exterior_color'=> '/Exterior Color<\/strong>\s*<\/td>\s*<td>\s*<span>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color<\/strong><\/td>\s*<td>\s*<span>(?<interior_color>[^<]+)/',
            'url'           => '/panel-title text-center">\s*<a href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine<\/td>\s*<td>(?<engine>[^<]+)/',
            'body_style'    => '/Body Style<\/td>\s*<td>(?<body_style>[^<]+)/',
            'transmission'  => '/Transmission<\/td>\s*<td>(?<transmission>[^<]+)/',
            'kilometres'        => '/Mileage<\/td>\s*<td>(?<kilometres>[^<]+)/',
        ),
        'next_page_regx'    => '/"hidden-xs">\s*<a href="(?<next>[^"]+)">/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*data-thumb/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );

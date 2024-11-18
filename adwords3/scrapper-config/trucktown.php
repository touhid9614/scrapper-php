<?php
    global $scrapper_configs;

    $scrapper_configs['trucktown'] = array(
        'entry_points' => array(
            //'new'   => 'http://www.wheatonchev.com/VehicleSearchResults?search=new',
            'used'  => 'https://www.lethbridgetrucktown.ca/used-inventory/index.htm'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'picture_selectors' => ['.jcarousel-item'],
            'picture_nexts'     => ['.imageScrollNext.next'],
            'picture_prevs'     => ['.imageScrollPrev.prev'],
        'details_start_tag' => '<ul class="inventoryList data full">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        
        'data_capture_regx' => array(
            'url'           => '/<a class="url" href="(?<url>[^"]+)">/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'price'         => '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/',
            'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'certified'     => '/<li class="(?<certified>certified)"><div class=\'badge\s*\'/',
        ),
        'data_capture_regx_full' => array(
        ) ,
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
        
    );
    
    
<?php
    global $scrapper_configs;

    $scrapper_configs['dubuqueautoplaza'] = array(
        'entry_points' => array(
            'new'       =>  array(
                'http://www.deerynissandubuque.com/new-inventory/index.htm',
                'https://www.bmwofdubuque.com/new-inventory/index.htm'
                ),
            'used'      => array(
                'http://www.deerynissandubuque.com/used-inventory/index.htm',
                'https://www.bmwofdubuque.com/used-inventory/index.htm'
                ),
            'certified'      => array(
                'http://www.deerynissandubuque.com/certified-inventory/index.htm',
                'https://www.bmwofdubuque.com/certified-inventory/index.htm'
                ),
            
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy'         => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>[^<]*)/',
            'year'          => '/data-year="(?<year>[0-9]{4})/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/(?:internetPrice final-price|stackedFinal final-price)"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>[^<]*)/',
            'certified'     => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/'
        ),
        'data_capture_regx_full' => array(
            
        ),
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );

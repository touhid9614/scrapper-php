<?php

    global $scrapper_configs;

    $scrapper_configs['dutchsauto'] = array(
        'entry_points' => array(
            'new'  => 'https://www.usedcarskentucky.com/new-cars-for-sale.php',
            'used' => 'https://www.usedcarskentucky.com/used-cars-for-sale.php',
            'certified' => 'https://www.usedcarskentucky.com/certified-pre-owned-inventory.php'
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.previous'],
        
        'details_start_tag' => '<div id="srp11list_1"',
        'details_end_tag'   => '<div class=legal',
        'details_spliter'   => '<a class=redbuttonsq',
        'data_capture_regx' => array(
            'url'           => '/<a itemprop="url" href="(?<url>[^"]+)/',
           // 'title'         => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/itemprop="vehicleModelDate">(?<year>[^<]+)/',
            'make'          => '/itemprop="brand">(?<make>[^<]+)/',
            'model'         => '/itemprop="model">(?<model>[^<]+)/',
            'trim'          => '/itemprop="vehicleConfiguration">(?<trim>[^<]+)/',
            'price'         => '/itemprop="price"[^>]+>(?<price>[^<]+)/',
            'kilometres'    => '/itemprop="mileageFromOdometer"[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'stock_number'  => '/itemprop="sku">(?<stock_number>[^<]+)/',
            'engine'        => '/itemprop="vehicleEngine"[^>]+>(?<engine>[^\<]+)/',
            'body_style'    => '/<span itemprop="vehicleCabType"[^>]+>(?<body_style>[^<]+)/',
          //  'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'exterior_color'=> '/itemprop="color">(?<exterior_color>[^<]+)/',
            'interior_color'=> '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
       //     'certified'     => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/',
        ),
        'data_capture_regx_full' => array(        
          /*  'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim' => '@"trim": "(?<trim>[^"]+)@'*/
        ) ,
        'next_page_regx'    => '/class=onpagebutton[^>]+>[^>]+>[^<]+<a href="(?<next>[^"]+)/',
        'images_regx'       => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
    );


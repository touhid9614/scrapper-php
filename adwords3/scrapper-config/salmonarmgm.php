<?php
    global $scrapper_configs;

    $scrapper_configs['salmonarmgm'] = array(
        'entry_points' => array(
            'used'  => 'https://www.salmonarmgm.com/used/',
            'new'   => 'https://www.salmonarmgm.com/new/',
         
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'=>false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span style=\'/',
            'year'                => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer[^>]+>[^>]+>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model[^>]+>[^>]+>(?<model>[^\<]+)/',
            'price'               => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
            'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
            //'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
            'stock_number'        => '/itemprop="sku">\s*(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
            'exterior_color'     =>  '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/data-src="(?<img_url>[^"]+)"/'
    );
    
   
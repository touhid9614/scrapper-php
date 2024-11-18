<?php

    global $scrapper_configs;

    $scrapper_configs['candscarcompany'] = array(
        'entry_points' => array(
            'new'  => 'http://www.candscarcompany.com/en/new-cars/?maxDisplay=1000',
            'used' => 'http://www.candscarcompany.com/en/used-cars/?maxDisplay=1000'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)-[0-9]{4}-/i',
       
        'use-proxy' => true,
        'picture_selectors' => ['#responsiveLayout .thumbnail ul li'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<div itemscope itemtype="http://schema.org/Product" class="inventoryRow pad-top-bottom-10',
        'details_end_tag'   => '<div class="row priceDisclaimer ',
        'details_spliter'   => '<div class="clearfix bottom-border-grey',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>[^"]+)".*itemprop="url"/',
            'year'          => '/hideYear">(?<year>[0-9]{4})[^>]+>\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]+)/',
            'make'          => '/hideYear">(?<year>[0-9]{4})[^>]+>\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]+)/',
            'model'         => '/Model:<\/dt>\s*<dd[^>]+>(?<model>[^\<]+)/',
            'trim'          => '/Trim:<\/dt>\s*<dd[^>]+>(?<trim>[^\<]+)/',
            'price'         => '/itemprop="price">\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd[^>]+>(?<kilometres>[^\<]+)/',
            'stock_number'  => '/Stock #:<\/dt>\s*<dd[^>]+>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd[^>]+>(?<engine>[^\<]+)/',
            'body_style'    => '/Body:<\/dt>\s*<dd[^>]+>(?<body_style>[^\&]*)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd[^>]+>(?<transmission>[^<]*)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd[^>]+>(?<exterior_color>[^<]*)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd[^>]+>(?<interior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(        
            
        ) ,
        //'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" rel="invThumbs"/',
        
    );


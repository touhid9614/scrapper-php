<?php

    global $scrapper_configs;

    $scrapper_configs['mycarsville'] = array(
        'entry_points' => array(
           // 'certified'   =>'http://www.mycarsville.ca/featured-vehicles/index.htm',
            'used'        => 'http://www.mycarsville.ca/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        
        'used'   => array(
            'use-proxy' => true,
            'picture_selectors' => ['.jcarousel-item'],
            'picture_nexts'     => [],
            'picture_prevs'     => [],
            'details_start_tag' => '<ul class="inventoryList data full',
            'details_end_tag'   => '<div class="ft">',
            'details_spliter'   => '<div class="item-compare">',
            'data_capture_regx' => array(
                'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
                'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
                'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
                'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
                'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
                'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
                'price'         => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
                'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
                'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
                'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
                'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
                'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
                'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
        ),
        'next_page_regx'        => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'           => '/<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com[^"]+)/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
     ),
//    'certified'   => array(
//        'use-proxy' => true,
//        'details_start_tag' => '<div class="bd2">',
//        'details_end_tag'   => '<footer class="region footer">',
//        'details_spliter'   => '<div class="yui3-u-1-2">',
//        'data_capture_regx' => array(
//            'stock_number'  => '/Stock Number[^>]+>:(?<stock_number>[^<]+)/',
//            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
//            'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
//            'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
//            'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
//            'price'         => '/Price<span class=\'separator\'>:<\/span><\/span><span class=\'value\'>(?<price>[^<]+)/',
//            'kilometres'    => '/Kilometres<\/strong>: (?<kilometers>[^<]+)/',
//            'engine'        => '/Engine<\/strong>: (?<engine>[^<]+)/',
//            'exterior_color'=> '/Exterior Colour<\/strong>: (?<exterior_color>[^<]+)/',
//            'transmission'  => '/Transmission<\/strong>: (?<transmission>[^<]+)/',
//            'body_style'    => '/Bodystyle<\/strong>: (?<bodystyle>[^<]+)/'
//        ),
//        'images_regx'       => '/<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com[^"]+)/'
//    ) 
);
    

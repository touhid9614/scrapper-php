<?php
    global $scrapper_configs;

    $scrapper_configs['landmarkford'] = array(
        'entry_points' => array(
            'new'   => 'http://www.landmarkford.net/new-inventory/index.htm',
            'used'  => 'http://www.landmarkford.net/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext'],
        'picture_prevs'     => ['.imageScrollPrev'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4}\s*(?<make>[^\s]+))\s*(?<model>[^\s*]+)[^<]+)/',
            'year'          => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4}\s*(?<make>[^\s]+))\s*(?<model>[^\s*]+)[^<]+)/',
            'make'          => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4}\s*(?<make>[^\s]+))\s*(?<model>[^\s*]+)[^<]+)/',
            'model'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4}\s*(?<make>[^\s]+))\s*(?<model>[^\s*]+)[^<]+)/',
            'price'         => '/final-price"><span[^>]+>[^<]+<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/',
           // 'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage\s*:<\/dt>\s*<dd>(?<kilometres>[^<]+)/',
            'url'           => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4}\s*(?<make>[^\s]+))\s*(?<model>[^\s*]+)[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/name="dl.make"\s*[^\s]+\s*value="(?<make>[^"]+)/',
            'model'         => '/name="dl.model"\s*[^\s]+\s*value="(?<model>[^"]+)/',
            'trim'          => '/name="dl.trim"\s*[^\s]+\s*value="(?<trim>[^"]+)/',
            'body_style'    => '/name="dl.bodyStyle"\s*[^\s]+\s*value="(?<body_style>[^"]+)/',
            
        ),
        'next_page_regx'    => '/rel="next"\s*(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/'
    );
    

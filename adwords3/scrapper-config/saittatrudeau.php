<?php
    global $scrapper_configs;

    $scrapper_configs['saittatrudeau'] = array(
        'entry_points' => array(
            'new'   => 'http://www.saittatrudeauchryslerjeepdodge.com/new-inventory/index.htm',
            'used'  => 'http://www.saittatrudeauchryslerjeepdodge.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.prev'],
        
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="url" href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'title'         => '/class="url" href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'price'         => '/final-price.*<span class=\'value\'\s*>(?<price>[^<]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'make'          => '/name="dl.make"\s*[^\s]+\s*value="(?<make>[^"]+)/',
            'stock_number'  => '/name="dl.vin"\s*[^\s]+\s*value="(?<stock_number>[^"]+)/',
            'model'         => '/name="dl.model"\s*[^\s]+\s*value="(?<model>[^"]+)/',
            'trim'          => '/name="dl.trim"\s*[^\s]+\s*value="(?<trim>[^"]+)/',
        ),
        'next_page_regx'    => '/rel="next" data-href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );

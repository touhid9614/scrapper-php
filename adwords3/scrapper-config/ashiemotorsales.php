<?php

    global $scrapper_configs;

    $scrapper_configs['ashiemotorsales'] = array (
        'entry_points'  => array(
           'used' => 'http://www.ashiemotorsales.com/used-inventory/index.htm',
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.prev'],
        
        'details_start_tag' => '<ul class="inventoryList data',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'title'         => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
            'stock_number'  => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Colou?r:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Colou?r:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
            'certified'     => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/',
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim' => '@"trim": "(?<trim>[^"]+)@'
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
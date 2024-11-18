<?php
    global $scrapper_configs;

    $scrapper_configs['lakeshoreford'] = array(
        'entry_points' => array(
            'new'   => 'http://www.lakeshoreford.net/new-inventory/index.htm',
            'used'  => 'http://www.lakeshoreford.net/used-inventory/index.htm',
            'certified'=>'http://www.lakeshoreford.net/certified-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.previous'],
        
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'title'         => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/(?:internetPrice final-price|stackedConditionalFinal)"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage\s*<\/span>\s*<span class="separator">:<\/span>\s*<span class="value">\s*(?<kilometres>[^\s]+)/',
            'stock_number'  => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim' => '@"trim": "(?<trim>[^"]+)@',
            'certified'     => '/"inventoryType":\s*"(?<certified>certified)"/'
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_lakeshoreford_field_images", "filter_lakeshoreford_field_images");
    
    function filter_lakeshoreford_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace(['|','?impolicy=resize&w=650'], ['%7C',''], $url);   
        }

        return $retval;
    }


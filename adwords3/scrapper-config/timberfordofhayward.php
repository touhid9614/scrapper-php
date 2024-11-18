<?php
    global $scrapper_configs;

    $scrapper_configs['timberfordofhayward'] = array(
        'entry_points' => array(
            'new'   => 'http://www.timberfordofhayward.com/new-inventory/index.htm',
            'used'  => 'http://www.timberfordofhayward.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/final-price"><span[^>]+>[^<]+<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior\s*Color:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior\s*Color:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage\s*:<\/dt>\s*<dd>(?<kilometres>[^<]+)/',
            'url'           => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',

        ),
        'data_capture_regx_full' => array(
            'make'          => '/name="dl.make"\s*[^\s]+\s*value="(?<make>[^"]+)/',
            'model'         => '/name="dl.model"\s*[^\s]+\s*value="(?<model>[^"]+)/',
            'trim'          => '/name="dl.trim"\s*[^\s]+\s*value="(?<trim>[^"]+)/',
            'body_style'    => '/name="dl.bodyStyle"\s*[^\s]+\s*value="(?<body_style>[^"]+)/',
            'price'         => '/final-price"\s*data-attribute-value="(?<price>[^"]+)/'
            
        ),
        'next_page_regx'    => '/rel="next"\s*(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'

    );  
     add_filter("filter_timberfordofhayward_field_images", "filter_timberfordofhayward_field_images");
    
    function filter_timberfordofhayward_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace('|', '%7C', $url);
        }

        return $retval;
    }





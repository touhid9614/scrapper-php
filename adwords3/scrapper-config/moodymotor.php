<?php
    global $scrapper_configs;

    $scrapper_configs['moodymotor'] = array(
        'entry_points' => array(
            'new'   => 'http://www.moodymotor.com/new-inventory/index.htm',
            'used'  => 'http://www.moodymotor.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
         'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare"> ',
     //   'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        'data_capture_regx' => array(
            'url'           => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'title'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'year'          => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'make'          =>'/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'model'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'stock_number'  => '/Stock\s*#:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'price'         => '/final-price"><span[^\:]+:<\/span><\/span><span\s*class=\'[^\']+\'\s*>(?<price>[^\<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'kilometres'    => '/Mileage\s*</span>\s*.*\s*.*\s*(?<kilometres>[^\<]+)/'
          
        ),
        'data_capture_regx_full' => array(     
               'body_style'    => '/BodyStyle<\/[^\:]+:\s*<\/span><strong\s*class="value">(?<body_style>[^\<]+)/'
        ),
        'next_page_regx'    => '/class=\'ddc-pagination-current-page\'>[0-9].*\s*.*\s*.*\s*<a\s*class="[^"]+"\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/'
    );
    add_filter("filter_moodymotor_field_images", "filter_moodymotor_field_images");
    
    function filter_moodymotor_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace('|', '%7C', $url);
        }

        return $retval;
    }
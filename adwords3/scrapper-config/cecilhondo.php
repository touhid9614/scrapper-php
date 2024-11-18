<?php
    global $scrapper_configs;

    $scrapper_configs['cecilhondo'] = array(
        'entry_points' => array(
            'new'   => 'http://www.cecilhondo.com/new-inventory/index.htm',
            'used'  => 'http://www.cecilhondo.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/+[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
         'use-proxy' => true,
        
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
        
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
     //   'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        'data_capture_regx' => array(
            'url'           => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^<]+)/',
            'title'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^<]+)/',
            'year'          => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^<]+)/',
            'make'          =>'/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^<]+)/',
            'model'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^<]+)/',
            'stock_number'  => '/Stock\s*#:<\/dt>\s*<dd>(?<stock_number>[^<]+)/',
            'price'         => '/final-price"><span[^>]+>[^<]+<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'interior_color'=> '/Interior\s*Color:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^<]+)/'
           
        ),
        'data_capture_regx_full' => array(          
            'make'          => '/name="dl.make"\s*[^\s]+\s*value="(?<make>[^"]+)/',
            'model'         => '/name="dl.model"\s*[^\s]+\s*value="(?<model>[^"]+)/',
            'condition_price' =>'/class="stackedConditionalFinal"\s*data-attribute-value="(?<condition_price>[^"]+)"/',
            'price'         => '/final-price"\s*data-attribute-value="(?<price>[^"]+)/'
        ),
        'next_page_regx'    => '/rel="next"\s*data-href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    
    add_filter("filter_cecilhondo_field_images", "filter_cecilhondo_field_images");
    function filter_cecilhondo_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace('|', '%7C', $url);
        }

        return $retval;
    }
    
   
    
    add_filter("filter_cecilhondo_field_price", "filter_cecilhondo_field_price", 10, 2);
    function filter_cecilhondo_field_price($price, $car_data) {
        slecho("Price is $price");
        
        slecho("Filtering Price");
        if(isset($car_data['condition_price']) && $car_data['condition_price']) {
            
            $price=min($price,$car_data['condition_price']);
            
        }
        slecho("Modified Price is $price");
        return $price;
    }
    
   
<?php

global $scrapper_configs;

$scrapper_configs['sherwoodbuickgmcdealer'] = array(
    'entry_points' => array(
        'new' => 'https://sherwoodbuickgmc.cms.dealer.com/new-inventory/index.htm',
        'used' => 'https://sherwoodbuickgmc.cms.dealer.com/used-inventory/index.htm',
    ),
    'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        //'proxy-area'        => 'CA',
        'picture_selectors' => ['.slider-slide img'],
        'picture_nexts'     => ['.pswp__button--arrow--right'],
        'picture_prevs'     => ['.pswp__button--arrow--left'],
        
         'details_start_tag' => '<div class="type-2 ddc-content"',
        'details_end_tag'   => '<div  class="ddc-footer"',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'title'         => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/Price[^>]+>:<\/span><\/span>[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Kilometres:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
            'stock_number'  => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',    
            'exterior_color'=> '/Exterior Colour:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
             'interior_color'=> '/Interior Colour:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
            
          
        ),
        'data_capture_regx_full' => array(      
         
            'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'price'         => '/final-price"><[^>]+>(?<price>\$[0-9,]+)/',
            'body_style'    => '@bodyStyle: \'(?<body_style>[^\']+)@',   
            'trim'          => '@"trim": "(?<trim>[^"]+)@',
            'vin'           => '/vin:\s*\'(?<vin>[^\']+)/',
            
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
       'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_sherwoodbuickgmcdealer_field_price", "filter_sherwoodbuickgmcdealer_field_price", 10, 3);
    add_filter("filter_sherwoodbuickgmcdealer_field_images", "filter_sherwoodbuickgmcdealer_field_images");
    function filter_sherwoodbuickgmcdealer_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/Dealer Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
      

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
     
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    function filter_sherwoodbuickgmcdealer_field_images($im_urls)
    {
           $retval = [];

    foreach ($im_urls as $img) {

        $retval[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }

    return $retval;
    }


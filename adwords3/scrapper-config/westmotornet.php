<?php
global $scrapper_configs;
$scrapper_configs["westmotornet"] = array( 
	  'entry_points' => array(
            'new'  => 'https://www.westmotor.net/new-inventory/index.htm',
            'used' => 'https://www.westmotor.net/used-inventory/index.htm',
        
        ),
         'vdp_url_regex'     => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.slider-slide img'],
        'picture_nexts'     => ['.ddc-icon-carousel-arrow-right'],
        'picture_prevs'     => ['.ddc-icon-carousel-arrow-left'],
        
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
            'vin'          => '/data-vin="(?<vin>[^"]+)/',
            'price'         => '/(?:Price|Sale Price)<[^>]+>:.*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'make'          => '/make\: \'(?<make>[^\']+)\'/',
            'model'         => '/model\: \'(?<model>[^\']+)\'/',
            'body_style'    => '/bodyStyle: \'(?<body_style>[^\']+)/',
            'trim'          => '/"trim": "(?<trim>[^"]+)/', 
             
            'description'   => '/Dealer Notes<[^=]+[^>]+>(?<description>[^\/]+)/',
            'fuel_type'     => '/Fuel Economy\<i[^\/]+[^\"]+\"[^\>]+>[^\>]+>(?<fuel_type>[^<]+)/',
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/"id":[^"]+"src"[^"]+"(?<img_url>[^"]+)"[^"]+"thumbnail/',
          'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
      
    );
    add_filter("filter_westmotornet_field_price", "filter_westmotornet_field_price", 10, 3);
    function filter_westmotornet_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
       
                
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
    
<?php

global $scrapper_configs;

$scrapper_configs['palestinetoyota'] = array(
    'entry_points' => array(
         'used'  => 'https://www.palestinetoyota.com/searchused.aspx',
          'new'   => 'https://www.palestinetoyota.com/searchnew.aspx'
           
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/(?:new|used)-[^-]+-[0-9]{4}/i',
        'ty_url_regex'      => '/\/thankyou.aspx/i',
        'picture_selectors' => ['.carousel__item'],
        'picture_nexts'     => ['.carousel__control--next'],
        'picture_prevs'     => ['.carousel__control--prev'],
        'details_start_tag' => '<!-- Vehicle Start -->',
        'details_end_tag'   => '<div class="row srpDisclaimer">',
        'details_spliter'   => '<!-- Vehicle End -->',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock\s*#: <\/strong>\s*(?<stock_number>[^<]+)/',
            'title'         => '/href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'year'          => '/href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'make'          => '/href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'model'         => '/href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'price'         => '/FINAL PRICE:\s*<\/span>\s*<span[^"]+"[^"]+" class="pull-right[^>]+>(?<price>[$0-9,]+)/',
            'engine'        => '/Engine: <\/strong>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color: <\/strong>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. Color: <\/strong>\s*(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:\s*<\/strong>\s*(?<kilometres>[^<]+)/',
            'url'           => '/href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'body_style'    => '/Body Style: <\/strong>\s*(?<body_style>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/vehicleMake="(?<make>[^"]+)/',
            'model'         => '/vehicleModel="(?<model>[^"]+)/',
            'trim'          => '@vehicleTrim="(?<trim>[^"]+)@'
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
        'images_regx'       => '/zoom feature element -->\s*<img src="(?<img_url>[^"]+)" alt/',
    );
    
     add_filter("filter_palestinetoyota_field_price", "filter_palestinetoyota_field_price", 10, 3);
    
    function filter_palestinetoyota_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Regex Selling Price: $price");
        }
        
       
        $msrp_regex      =  '/MSRP:\s*[^>]+>[^>]+>(?<price>[$0-9,]+)/';
        $internet_regex      =  '/Internet Price\s*<\/span>\s*<span[^"]+"[^"]+" class="pull-right[^>]+>(?<price>[$0-9,]+)/';
        $matches = [];
      
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
       if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Internet price: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }

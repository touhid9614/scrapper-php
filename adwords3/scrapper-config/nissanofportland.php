<?php
global $scrapper_configs;
 $scrapper_configs["nissanofportland"] = array( 
         'entry_points' => array(
            'new'   => 'https://nissanofportland.com/inventory/New/',
            'used'  => 'https://nissanofportland.com/inventory/Used/'
        ),
        'vdp_url_regex'     => '/\/inventory-(?:new|used)\/[0-9]{4}\/i',
        //'ty_url_regex'      => '/\/contact-form-confirm.htm/i',
        'use-proxy' => true,
        'refine'            => false,
        //'proxy-area'        => 'FL',
        'details_start_tag' => '<ul id="designhouse5-listing-items" class="list used">',
        'details_end_tag'   => '<!-- END of CONTENT -->',
        'details_spliter'   => '<li class="designhouse5-item',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>(?<stock_number>[^<]+)/',
            //'title'         => '/<a href="(?<url>[^"]+)" title="(?<title>(?<year>[^ ]+)\s*(?<make>[^ ]+)\s*(?<model>[^ <]+)[^<]*)"><span/',
            'year'          => '/year">(?<year>[0-9]{4})/',
            'make'          => '/make">(?<make>[^<]+)/',
            'model'         => '/model">(?<model>[^<]+)/',
            'trim'          => '/trim">(?<trim>[^<]+)/',
            'price'         => '/NOP Price\s+<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
            'body_style'    => '/Body Style\s*<\/td><td class="value">(?<body_style>[^<]+)/',
            'engine'        => '/Engine\s*<\/td><td class="value">(?<engine>[^<]+)/',
            'transmission'  => '/Transmission\s*<\/td><td class="value">(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Color\s*<\/td><td class="value">(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color\s*<\/td><td class="value">(?<interior_color>[^<]+)/',
            'kilometres'    => '/Odometer\s*<\/td><td class="value">(?<kilometres>[^<]+)/',
            'url'           => '/<a href="(?<url>[^"]+)" title="(?<title>(?<year>[^ ]+)\s*(?<make>[^ ]+)\s*(?<model>[^ <]+)[^<]*)"><span/'
        ),
        'next_page_regx'    => '/class=\'page-numbers current\'>[0-9]*<\/span>\s*<a class=\'page-numbers\' href=\'(?<next>[^\&]+)/',
//        'images_regx'       => '/<li>\s*<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com\/c\/[^"]+)" class="">/',
        'images_regx'       => '/rel="slides" href="(?<img_url>[^"]+)"/',
       // 'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
 
    $nissanofportland_paginations = [];
 
    add_filter('filter_nissanofportland_data', 'filter_nissanofportland_data', 10, 2);
    
    function filter_nissanofportland_data($data, $stock_type) {
        global $nissanofportland_paginations;
        
        if(!isset($nissanofportland_paginations[$stock_type])) {
            $nissanofportland_paginations[$stock_type] = 1;
        } else {
            $nissanofportland_paginations[$stock_type]++;
        }
        
        $pdata = HttpGet("https://nissanofportland.com/wp-admin/admin-ajax.php?action=get_pagination&page={$nissanofportland_paginations[$stock_type]}&type=$stock_type");
        
        return "$data\n\n$pdata";
    }
 
    add_filter("filter_nissanofportland_field_images", "filter_nissanofportland_field_images");
    
    function filter_nissanofportland_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'unavailable_stockphoto.png');
        });
    }
    add_filter("filter_nissanofportland_field_price", "filter_nissanofportland_field_price", 10, 3);
    function filter_nissanofportland_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("nissanofportland Price: $price");
            }

            $retail_regex =  '/Asking Price\s*<\/span>\s*<span[^>]+>(?<price>\$[0-9,]+)/';
            $asking_regex =  '/NOP Price\s+<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
           
            $matches = [];
            
            if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex lot price: {$matches['price']}");
            }
            if(preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex asking price: {$matches['price']}");
            }

            if(count($prices) > 0) {
                $price = butifyPrice(min($prices));
            }

            slecho("Sale Price: {$price}".'<br>');
            return $price;
        }

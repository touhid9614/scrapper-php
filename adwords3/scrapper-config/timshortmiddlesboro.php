<?php

    global $scrapper_configs;

    $scrapper_configs['timshortmiddlesboro'] = array(
        'entry_points' => array(
            'new'  => 'http://www.timshortmiddlesboro.com/new-inventory/index.htm',
            'used' => 'http://www.timshortmiddlesboro.com/used-inventory/index.htm',
           //'certified' => 'http://www.timshortmiddlesboro.com/certified-inventory/index.htm'
        ),
        
        
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        
        
        
        'picture_selectors' => ['.jcarousel li'],
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
            'price'         => '/final-price"><span[^>]+>[^<]+<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
            'stock_number'  => '/VIN: <\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
           // 'certified'     => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/'
        ),
        'data_capture_regx_full' => array(        
//            'make'          => '@make\: \'(?<make>[^\']+)\'@',
//            'model'         => '@model\: \'(?<model>[^\']+)\'@',
//            'body_style'    => '@bodyStyle: \'(?<body_style>[^\']+)@',
//            'trim'          => '@"trim": "(?<trim>[^"]+)@'
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/'
    );


    
    
    
    
//    add_filter("filter_timshortmiddlesboro_field_price", "filter_timshortmiddlesboro_field_price", 10, 3);
//    //add_filter("filter_timshortmiddlesboro_field_images", "filter_timshortmiddlesboro_field_images");
//    add_filter('filter_timshortmiddlesboro_field_stock_type','filter_timshortmiddlesboro_field_stock_type');
//
//    function filter_timshortmiddlesboro_field_price($price,$car_data, $spltd_data)
//    {
//        $prices = [];
//        
//        slecho('');
//        
//        if($price && numarifyPrice($price) > 0) {
//            $prices[] = numarifyPrice($price);
//            slecho(" Price: $price");
//        }
//        
//        $msrp_regex       =  '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
//        $internet_regex   =  '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
//        $cond_final_regex =  '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//        $retail_regex     =  '/retailValue"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//        $asking_regex     =  '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//
//                
//        $matches = [];
//        
//        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//            $prices[] = numarifyPrice($matches['price']);
//            slecho("Regex MSRP: {$matches['price']}");
//        }
//        if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//            $prices[] = numarifyPrice($matches['price']);
//            slecho("Regex internet: {$matches['price']}");
//        }
//       
//        if(preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//            $prices[] = numarifyPrice($matches['price']);
//            slecho("Regex Conditional Price: {$matches['price']}");
//        }
//        
//        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//            $prices[] = numarifyPrice($matches['price']);
//            slecho("Regex Retail Price: {$matches['price']}");
//        }
//        if(preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//            $prices[] = numarifyPrice($matches['price']);
//            slecho("Regex Asking Price: {$matches['price']}");
//        }
//        
//        if(count($prices) > 0) {
//            $price = butifyPrice(min($prices));
//        }
//        
//        slecho("Sale Price: {$price}".'<br>');
//        return $price;
//    }
//    
//    function filter_timshortmiddlesboro_field_images($im_urls)
//    {
//        return array_filter($im_urls, function($im_url){
//            return !endsWith($im_url, 'unavailable_stockphoto.png');
//        });
//    }
    
//    function filter_timshortmiddlesboro_field_stock_type($stock_type)
//    {
//        $used_stock_type = ['certified','exotic-used'];
//        if (in_array($stock_type,$used_stock_type)) { $stock_type = 'used'; } 
//        return $stock_type;
//    }

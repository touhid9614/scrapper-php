<?php
    global $scrapper_configs;

    $scrapper_configs['shortredmondford'] = array(
        'entry_points' => array(
            'new'   => 'http://www.short-redmondford.com/new-inventory/index.htm',
            'used'  => 'http://www.short-redmondford.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
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
            'price'         => '/final-price.*class=\'value[^>]+>\$(?<price>[^<]+)/',
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:<[^>]+>[^>]+>(?<kilometres>[^<]+)/',
       
            
            
        ),
        'data_capture_regx_full' => array(        
//            'make'          => '@make\: \'(?<make>[^\']+)\'@',
//            'model'         => '@model\: \'(?<model>[^\']+)\'@',
//            'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
//            'trim' => '@"trim": "(?<trim>[^"]+)@'
        ) ,
        
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_shortredmondford_field_price", "filter_shortredmondford_field_price", 10, 3);
    function filter_shortredmondford_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Adjusted Final Price: $price");
        }
       
        $internet_regex =  '/internetPrice">.*class=\'value[^>]+>\$(?<price>[0-9,]+)/';
        $asking_regex   =  '/askingPrice">.*class=\'value[^>]+>\$(?<price>[0-9,]+)/';
        $retail_regex   =  '/retailValue">.*class=\'value[^>]+>\$(?<price>[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Internet Price: {$matches['price']}");
        }
        if(preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Asking Price: {$matches['price']}");
        }
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Retail Price: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
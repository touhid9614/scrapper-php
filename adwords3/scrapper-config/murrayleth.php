<?php

    global $scrapper_configs;

    $scrapper_configs['murrayleth'] = array(
        'entry_points' => array(
            'new'   => 'https://www.murraychev.com/new-inventory/index.htm',
            'used'  => 'https://www.murraychev.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/contact-form-confirm.htm/i',
        'use-proxy' => true,
        //'proxy-area'        => 'FL',
        'picture_selectors' => ['.jcarousel li'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
        'details_start_tag' => '<ul class="inventoryList full',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'certified'     => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/'
        ),
        'data_capture_regx_full' => array(
            'trim'          => '/"trim": "(?<trim>[^"]+)/'
        ),

        'options_start_tag' => '<dt>Options</dt>',
        'options_end_tag'   => '</dd>',
        'options_regx'      => '/<li><span>(?<option>[^<]+)/',
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com[^"]+)/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_murrayleth_field_price", "filter_murrayleth_field_price", 10, 3);
    add_filter("filter_murrayleth_car_data", "filter_murrayleth_car_data");
    
    function filter_murrayleth_car_data($car_data) {
        
            if((stripos($car_data['model'], 'Camaro') !== false) || (stripos($car_data['model'], 'Corvette') !== false)) {
                slecho("Excluding vehicle :- {$car_data['url']}");
                return null;
            }
        
        return $car_data;
    }

    
    function filter_murrayleth_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
        $internet_regex   =  '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
        $cond_final_regex =  '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
        $asking_regex     =  '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex internet: {$matches['price']}");
        }
       
        if(preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Conditional Price: {$matches['price']}");
        }
        
        if(preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Asking Price: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }

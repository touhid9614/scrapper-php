<?php
    global $scrapper_configs;

    $scrapper_configs['rhinebeckfordinc'] = array(
        'entry_points' => array(
            'new'   => 'http://www.rhinebeckfordinc.com/new-inventory/index.htm',
            'used'  => 'http://www.rhinebeckfordinc.com/used-inventory/index.htm',
            'certified' => 'http://www.rhinebeckfordinc.com/certified-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel li'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.prev'],
        
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
            'price'         => '/final-price"><span[^>]+>[^<]+.*<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
            'stock_number'  => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
            'certified'     => '/class="url"\s*href="\/(?<certified>certified)/'
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style'    => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim'          => '@"trim": "(?<trim>[^"]+)@'
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/'
    );
    add_filter("filter_rhinebeckfordinc_field_price", "filter_rhinebeckfordinc_field_price", 10, 3);
    function filter_rhinebeckfordinc_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("rhinebeckfordinc Price: $price");
        }
        
        $msrp_regex =  '/MSRP.*class=\'value[^>]+>(?<price>[^<]+)/';
        $retail_regex =  '/retailValue"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
        $cond_final_regex =  '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Retail Price: {$matches['price']}");
        }
        if(preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Stack conditional: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }




<?php

    global $scrapper_configs;

    $scrapper_configs['edmurdocksuperstores'] = array(
        'entry_points' => array(
            'new'   => 'http://www.edmurdocksuperstores.com/new.cfm',
            'used'  => 'http://www.edmurdocksuperstores.com/used.cfm',
        ),
        'vdp_url_regex'     => '/\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.carousel.c-fade .item'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<form name="COMPARESELECTED"',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div class="panel panel-default toc">',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>[^"]+)" class="vdplink"[^\n]+\s*<h3/',
            'year'          => '/class="vdplink"[^\n]+\s*<h3>(?:New|Used)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'make'          => '/class="vdplink"[^\n]+\s*<h3>(?:New|Used)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'model'         => '/class="vdplink"[^\n]+\s*<h3>(?:New|Used)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'trim'          => '/class="sTrim">(?<trim>[^<]+)/',
            'price'         => '/NOW ONLY\s*<span[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:(?<kilometres>[^<]+)/',
            'stock_number'  => '/Stock:&nbsp;(?<stock_number>[^<]+)/',
            'engine'        => '/Engine:&nbsp;(?<engine>[^<]+)/',
          //  'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Trans:&nbsp;(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. Color:(?<interior_color>[^<]+)/',
        ),
        'data_capture_regx_full' => array(        
            'body_style'    => '@>Style<\/strong><\/td><td[^>]+>(?<body_style>[^<]+)@',
            
        ) ,
        'next_page_regx'    => '/<li class="active"><a href="[^"]+">[^<]+<\/a><\/li><li><a href="(?<next>[^"]+)/',
        'images_regx'       => '/class="item[^\n]+>\s*<a[^>]+>.*<img src="[^"]+" data-src="(?<img_url>[^"]+)"/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_edmurdocksuperstores_field_price", "filter_edmurdocksuperstores_field_price", 10, 3);
    function filter_edmurdocksuperstores_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];

        slecho('');

        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("edmurdocksuperstores Price: $price");
        }

        $msrp_regex =  '/MSRP\s*<span[^>]+>(?<price>\$[0-9,]+)/';
        

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

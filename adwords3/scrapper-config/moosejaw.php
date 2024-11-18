<?php

    global $scrapper_configs;

    $scrapper_configs['moosejaw'] = array(
        'entry_points' => array(
            'new'   => 'https://www.moosejawfordsales.com/searchnew.aspx',
            'used'  => 'https://www.moosejawfordsales.com/searchused.aspx'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/(?:new|used)-[^-]+-[0-9]{4}/i',
        'ty_url_regex'      => '/\/thankyou.aspx/i',
        'picture_selectors' => ['#vehicleImgLarge .carousel-inner .item .row','.mfp-figure .mfp-img '],
        'picture_nexts'     => ['.mfp-arrow.mfp-arrow-right'],
        'picture_prevs'     => ['.mfp-arrow.mfp-arrow-left'],
        'details_start_tag' => '<!-- Vehicle Start -->',
        'details_end_tag'   => '<div class="row srpDisclaimer">',
        'details_spliter'   => '<!-- Vehicle End -->',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock\s*#: <\/strong>\s*(?<stock_number>[^<]+)/',
            'title'         => '/class="vehicleTitle margin-x">\s*<a href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'year'          => '/class="vehicleTitle margin-x">\s*<a href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'make'          => '/class="vehicleTitle margin-x">\s*<a href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'model'         => '/data-model=\'(?<model>[^\']+)/',
            'price'         => '/Selling Price:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/',
            'engine'        => '/Engine: <\/strong>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission: <\/strong>\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color: <\/strong>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. Color: <\/strong>\s*(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometers: <\/strong>\s*(?<kilometres>[^<]+)/',
            'url'           => '/class="vehicleTitle margin-x">\s*<a href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
            'body_style'    => '/Body Style: <\/strong>\s*(?<body_style>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/vehicleMake="(?<make>[^"]+)/',
            'model'         => '/vehicleModel="(?<model>[^"]+)/',
            'trim'          => '@vehicleTrim="(?<trim>[^"]+)@'
        ) ,
        'next_page_regx'    => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
        'images_regx'       => '/<div class="col-lg-3 col-md-6 col-sm-6 thumbs" onclick="[^"]+" href="(?<img_url>[^"]+)">/',
    );
    
     add_filter("filter_moosejaw_field_price", "filter_moosejaw_field_price", 10, 3);
    
    function filter_moosejaw_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Regex Selling Price: $price");
        }
        
        $internet_regex  =  '/Internet Price:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';
        $retail_regex    =  '/Retail Price:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';
        $msrp_regex      =  '/MSRP:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Sale Price: {$matches['price']}");
        }
        
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Price: {$matches['price']}");
        }
        
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

<?php
    global $scrapper_configs;

    $scrapper_configs['rosevilletoyota'] = array(
       'entry_points' => array(
            'used'  => 'https://www.rosevilletoyota.com/searchused.aspx',
            'new'   => 'https://www.rosevilletoyota.com/searchnew.aspx',
            
            
        ),
        'vdp_url_regex'     => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
        'use-proxy' => true,
        
        'picture_selectors' => ['.carousel__item.js-carousel__item img'],
        'picture_nexts'     => ['.js-carousel__control--next'],
        'picture_prevs'     => ['.js-carousel__control--prev'],
        
        'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
        'details_end_tag'   => '<div class="row srpDisclaimer">',
        'details_spliter'   => '<div id="srpRow-',
        
        'data_capture_regx' => array(
            'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'make'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'model'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
            'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
            'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
            'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
            'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
            'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
            'price'            => '/(?:Price|Final Price:)\s*<\/span><span[^>]+>\$(?<price>[^<]+)/',
            'msrp'             => '/MSRP: <\/span><span class="pull-right">(?<msrp>[^<]+)/',
            'vin'              => '/VIN #: <\/strong><span>(?<vin>[^<]+)/',
            'drivetrain'       => '/Drive Type: <\/strong>(?<drivetrain>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'body_style'      => '/Body Style:\s*<\/strong><span>(?<body_style>[^<]+)/',
            'make'            => '/var vehicleMake="(?<make>[^"]+)/',
            'model'           => '/var vehicleModel="(?<model>[^"]+)/',
            
        ) ,
        
        'next_page_regx'    => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
        'images_regx'       => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
    );
    
      add_filter('filter_rosevilletoyota_field_price', 'filter_rosevilletoyota_field_price',10,3);
    
    function filter_rosevilletoyota_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Internet Price: $price");
        }
        
        $msrp_regex =  '/MSRP:\s*[^"]+"[^"]+"\s*>\$(?<price>[^<\/]+)/';
        $retail_regex =  '/Retail Price:\s*[^"]+"[^"]+"\s*>\$(?<price>[^<\/]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Retail: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    



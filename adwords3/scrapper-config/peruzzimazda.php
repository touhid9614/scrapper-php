<?php
    global $scrapper_configs;

    $scrapper_configs['peruzzimazda'] = array(
        'entry_points' => array(
            'new'  => 'https://www.peruzzimazda.com/searchnew.aspx',
            'used' => 'https://www.peruzzimazda.com/searchused.aspx'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)-Fairless[^-]+-[0-9]{4}-/i',
        'use-proxy' => false,
        'picture_selectors' => ['.carousel__item'],
        'picture_nexts'     => ['.carousel__control--next'],
        'picture_prevs'     => ['.carousel__control--prev'],
        'details_start_tag' => '<div class="row srpVehicle">',
        'details_end_tag'   => '<div class="row srpDisclaimer">',
        'details_spliter'   => '<div id="srpRow-',
        
        'data_capture_regx' => array(
            'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'make'             => '/listings\..*make:"(?<make>[^"]+)/',
            'model'            => '/listings\..*model:"(?<model>[^"]+)/',
            'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
            'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
            'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
            'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
            'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
            'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
            'price'            => '/FINAL PRICE:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(
            'transmission'    => '/Transmission[^<]+<\/span>\s*<h3[^>]+>(?<transmission>[^<]+)/',
            'body_style'      => '/Body Style\s*<\/span>\s*<h3[^>]+>(?<body_style>[^<]+)/',
            'make'            => '/var vehicleMake="(?<make>[^"]+)/',
            'model'           => '/var vehicleModel="(?<model>[^"]+)/'
        ) ,
        
        'next_page_regx'    => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
        'images_regx'       => '/<div class="carousel__item js-carousel__item[^>]+><img src="(?<img_url>[^"]+)/',
    );
    add_filter('filter_peruzzimazda_field_price', 'filter_peruzzimazda_field_price',10,3);
    
    function filter_peruzzimazda_field_price($price,$car_data,$spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        $price_regex       =  '/>Price\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
              
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
       
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
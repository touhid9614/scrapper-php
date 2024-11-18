<?php
global $scrapper_configs;
$scrapper_configs["griffinshubchryslerjeepdodgecom"] = array( 
	'entry_points' => array(
            'new'  => 'https://www.griffinshubchryslerjeepdodge.com/searchnew.aspx',
            'used' => 'https://www.griffinshubchryslerjeepdodge.com/searchused.aspx'
        ),
        'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
        'use-proxy' => true,
        'refine' => false,
    
         'picture_selectors' => ['.carousel__image'],
         'picture_nexts' => ['.carousel__control--next'],
         'picture_prevs' => ['.carousel__control--prev'],
    
        'details_start_tag' => '<div class="row srpSort">',
        'details_end_tag'   => '<div class="row srpDisclaimer">',
        'details_spliter'   => '<div id="srpRow-',
        
        'data_capture_regx' => array(
            'url'              => '/class="vehicleTitle.*\s.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
           // 'title'            => '/class="vehicleTitle.*\s.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'year'             => '/class="vehicleTitle.*\s.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'make'             => '/class="vehicleTitle.*\s.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'model'            => '/class="vehicleTitle.*\s.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'trim'            => '/class="vehicleTitle.*\s.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
            'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
            'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
            'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
            'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
            'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
            'price'            => '/GRIFFIN PRICE:\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(
            'transmission'    => '/Transmission[^<]+<\/span>\s*<h3[^>]+>(?<transmission>[^<]+)/',
            'body_style'      => '/Body Style\s*<\/span>\s*<h3[^>]+>(?<body_style>[^<]+)/',
            'make'            => '/var vehicleMake="(?<make>[^"]+)/',
            'model'           => '/var vehicleModel="(?<model>[^"]+)/'
        ) ,
        
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
         'images_regx' => '/<img src="(?<img_url>[^\?]+)\?height/',
    );
add_filter("filter_griffinshubchryslerjeepdodgecom_field_price", "filter_griffinshubchryslerjeepdodgecom_field_price", 10, 3);
        function filter_griffinshubchryslerjeepdodgecom_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("griffinshubchryslerjeepdodgecom Price: $price");
            }
           $retail_regex =  '/Internet Price\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
            $msrp_regex =  '/MSRP:\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
            $internet_regex =  '/Internet Price\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
            $matches = [];
            if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex retail: {$matches['price']}");
            }
            if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex MSRP: {$matches['price']}");
            }
         
            if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex internet: {$matches['price']}");
            }
            if(count($prices) > 0) {
                $price = butifyPrice(min($prices));
            }

            slecho("Sale Price: {$price}".'<br>');
            return $price;
        }



   
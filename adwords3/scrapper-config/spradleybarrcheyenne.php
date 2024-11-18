<?php
    global $scrapper_configs;

    $scrapper_configs['spradleybarrcheyenne'] = array(
        'entry_points' => array(
            'new'   => 'http://www.spradleybarrcheyenne.com/searchnew.aspx',
            'used'  => 'http://www.spradleybarrcheyenne.com/searchused.aspx'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thankyou.aspx/i',
        //'use-proxy'         => true,
        'proxy-area'        => 'FL',
        'picture_selectors' => ['.thumbs'],
       // 'picture_nexts'     => ['.carousel__button--next'],
       // 'picture_prevs'     => ['.carousel__button--previous'],
        'details_start_tag'   => '<!-- Vehicle Start -->',
        'details_end_tag'     => '<div class="row srpDisclaimer">',
        'details_spliter'      => '<div id="srpRow-',
        
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
            'price'            => '/FINAL PRICE:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(      
            'transmission'    => '/Transmission:\s*<\/strong><span>(?<transmission>[^<]+)/',
            'body_style'      => '/Body Style:\s*<\/strong><span>(?<body_style>[^<]+)/',
            'make'            => '/var vehicleMake="(?<make>[^"]+)/',
            'model'           => '/var vehicleModel="(?<model>[^"]+)/'
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
        'images_regx'       => '/<img\s*class=\'img-responsive\'\s*src="(?<img_url>[^"]+)"/',
    );
    add_filter('filter_spradleybarrcheyenne_field_price', 'filter_spradleybarrcheyenne_field_price',10,3);
    add_filter("filter_spradleybarrcheyenne_field_images", "filter_spradleybarrcheyenne_field_images");

    
    function filter_spradleybarrcheyenne_field_price($price,$car_data,$spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        $price_regex      =  '/>Price\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        $spradleybrad_regex   = '/Spradley Barr Price:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
              
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }
        if(preg_match($spradleybrad_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Spradley Barr: {$matches['price']}");
        }
       
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    

    function filter_spradleybarrcheyenne_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'photo_unavailable_640.jpg');
        });
    }

<?php
global $scrapper_configs;
$scrapper_configs["kurtischevroletcom"] = array( 
	   'entry_points' => array(
                'new' => 'https://www.kurtischevrolet.com/searchnew.aspx?Dealership=Kurtis%20Chevrolet',
                'used'=> 'https://www.kurtischevrolet.com/searchused.aspx?Dealership=Kurtis%20Chevrolet'
        ),
        'vdp_url_regex'       => '/(?:new|used)-[^\-]+-[0-9]{4}-/i',
        'refine'              => false,
        'ty_url_regex'        => '/\/thankyou.aspx/i',
        'use-proxy'           => true,
        // 'proxy-area'        => 'FL',
        'picture_selectors' => ['.carousel__item'],
        'picture_nexts'     => ['.carousel__control--next'],
        'picture_prevs'     => ['.carousel__control--prev'],
        
        'details_start_tag'   => 'class="row srpVehicle"',
        'details_end_tag'     => '<div class="row srpDisclaimer">',
        'details_spliter'     => '<div id="srpRow-',

        'data_capture_regx' => array(
                'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
                'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
                'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
                'make'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
                'model'            => '/data-model=\'(?<model>[^\']+)/',
                'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
                'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
                'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
                'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
                'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
                'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
                'vin'              => '/<strong>VIN\s*#:\s*[^>]+>[^>]+>(?<vin>[^<]+)/',
                'kilometres'       => '/Mileage:\s*<\/strong>(?<kilometres>[^<]+)/',
                'price'            => '/(?:Kurtis Price|Internet Price).\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',

            ),
        'data_capture_regx_full' => array(
                'make'             => '/brand":\s*"(?<make>[^"]+)/',
                'model'            => '/model":\s*"(?<model>[^"]+)/',
                'trim'             => '/var vehicleTrim="(?<trim>[^"]+)/'
        ),
   
        'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next" data-loc="available inventory">\s*Next/',
        'images_regx'   => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
    );

     add_filter("filter_kurtischevroletcom_field_images", "filter_kurtischevroletcom_field_images");
     add_filter('filter_kurtischevroletcom_field_price', 'filter_kurtischevroletcom_field_price',10,3);

        function filter_kurtischevroletcom_field_images($im_urls)
        {
            if(count($im_urls) < 2) { return array(); }
            return array_filter($im_urls, function($im_url){
                return !endsWith($im_url, 'photo_unavailable_320.gif');
            });
        }
 
    
    function filter_kurtischevroletcom_field_price($price,$car_data,$spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        $market_regex     =  '/Market Value:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
              
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($market_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex market: {$matches['price']}");
        }
       
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }


<?php
global $scrapper_configs;
$scrapper_configs["griffinfordfortatkinsoncom"] = array( 
		'entry_points' => array(
             'used' => 'https://www.griffinfordfortatkinson.com/searchused.aspx',
            'new'  => 'https://www.griffinfordfortatkinson.com/searchnew.aspx',
           
        ),
        'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
        'use-proxy' => true,
        'srp_page_regex'         => '/\/search(?:new|used|certified)/i',
        'refine' => false,
        'picture_selectors' => ['.carousel__item'],
        'picture_nexts'     => ['.carousel__control--next'],
        'picture_prevs'     => ['.carousel__control--prev'],
        'details_start_tag' => '<div class="row srpSort">',
        'details_end_tag'   => '<div class="row srpDisclaimer">',
        'details_spliter'   => '<div id="srpRow-',
        
        'data_capture_regx' => array(
            'url'              => '/class="vehicleTitle.*\s.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
          
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
            'kilometres'       => '/Mileage:\s*<\/strong>(?<kilometres>[^<\/]+)/',
            'price'            => '/Selling Price[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(
           'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
        ) ,
        
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
        'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
    );
add_filter("filter_griffinfordfortatkinsoncom_field_price", "filter_griffinfordfortatkinsoncom_field_price", 10, 3);
        function filter_griffinfordfortatkinsoncom_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("griffinfordfortatkinsoncom Price: $price");
            }
           $retail_regex =  '/Retail Price:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
            $msrp_regex =  '/MSRP[^>]+>[^>]+>(?<price>\$[0-9,]+))/';
            $internet_regex =  '/Final Price[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
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



   add_filter("filter_griffinfordfortatkinsoncom_field_images", "filter_griffinfordfortatkinsoncom_field_images");
    
    function filter_griffinfordfortatkinsoncom_field_images($im_urls)
    {
      return array_filter($im_urls, function($im_url) {
         return !endsWith($im_url, 'photo_unavailable_640.png');
    });
       
       
    }
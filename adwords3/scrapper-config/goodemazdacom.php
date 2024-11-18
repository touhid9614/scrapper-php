<?php
global $scrapper_configs;
$scrapper_configs["goodemazdacom"] = array( 
	 'entry_points' => array(
            'new'  => 'https://www.goodemazda.com/searchnew.aspx',
            'used' => 'https://www.goodemazda.com/searchused.aspx'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)-Tyler[^-]*-[0-9]{4}/i',
        //'use-proxy' => true,
        'proxy-area'        => 'FL',
         'refine'=>false,
    'picture_selectors' => ['.mfp-img'],
    'picture_nexts' => ['.mfp-arrow-right'],
    'picture_prevs' => ['.mfp-arrow-left'],
        'details_start_tag' => '<!-- Vehicle Start -->',
        'details_end_tag'   => '<div class="row srpDisclaimer">',
        'details_spliter'   => '<div id="srpRow-',
        
        'data_capture_regx' => array(
            'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'make'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'model'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
            'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
            'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
            'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
            'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
            'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
            'price'            => '/Goode Mazda Price:\s*[^>]+>[^>]+>(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'body_style'      => '/Body Style:\s*<\/strong><span>(?<body_style>[^<]+)/',
            'make'            => '/var vehicleMake="(?<make>[^"]+)/',
            'model'           => '/var vehicleModel="(?<model>[^"]+)/'
        ) ,
        
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"/',
       'images_regx' => '/<img class=\'img-responsive\' src="(?<img_url>[^\?]+)\?width=[^"]+"\s*alt/',
    );
    add_filter('filter_goodemazdacom_field_price', 'filter_goodemazdacom_field_price',10,3);
    
    function filter_goodemazdacom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Internet Price: $price");
        }
        
        $msrp_regex =  '/MSRP:\s*[^>]+>[^>]+>(?<price>[^<]+)/';
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
    
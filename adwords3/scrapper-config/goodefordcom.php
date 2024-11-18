<?php
global $scrapper_configs;
$scrapper_configs["goodefordcom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.goodeford.com/searchnew.aspx',
        'used' => 'https://www.goodeford.com/searchused.aspx'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<footer class="full',
    'details_spliter' => '<div id="srpVehicle',
    'data_capture_regx' => array(
            'url' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/',
        'title' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/',
        'year' => '/data-year=\'(?<year>[^\']+)/',
        'make' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/',
      //  'model' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/',
        'model' => '/data-model=\'(?<model>[^\']+)/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'vin' => '/<strong>VIN\s*#:\s*[^>]+><span>(?<vin>[^<]+)/',
        'drivetrain' => '/<strong>Drive\sType*:\s*[^>]+>(?<drivetrain>[^<]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/(?:MSRP:|Vehicle Price:)\s*<\/span>[^>]+>(?<price>[^<]+)/',
      
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
    //'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_goodefordcom_field_price", "filter_goodefordcom_field_price", 10, 3);

    function filter_goodefordcom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Adjusted Price: $price");
        }
        
        $msrp_regex =  '/Goode Ford Price\s*<\/span>[^>]+>(?<price>[^<]+)/';
        
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



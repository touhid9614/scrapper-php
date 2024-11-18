<?php

global $scrapper_configs;

$scrapper_configs['applewoodauto'] = array(
    'entry_points' => array(
        'new' => 'https://www.applewoodauto.com/new/',
        'used' => 'https://www.applewoodauto.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    //'use-proxy' => true,
    'proxy-area'        => 'FL',
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next-small'],
    'picture_prevs' => ['.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<div class="footer_paragraph_wrap">',
    'details_spliter' => '<input type="hidden" style="display:none;" id="vehicle_owner_dealer_id',
    'data_capture_regx' => array(
        'url' => '/<a itemprop="url"\s+onclick=".+ href="(?<url>[^"]+)">/',
        //'title' => '//',
        'year' => '/itemprop=\'releaseDate\'>(?<year>[0-9]+)<\/span>/',
        'make' => '/itemprop=\'manufacturer\'>(?<make>[0-9a-zA-Z\s]+)<\/span>/',
        'model' => '/itemprop=\'model\'>(?<model>[0-9a-zA-Z\s]+)+<\/span>/',
        //'trim' => '//',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer".+>(?<kilometres>[0-9,]+\skm)<\/span>/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[0-9a-zA-Z]+)<\/td>/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>.+cyl)<\/td>/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[0-9a-zA-Z\s]+)<\/td><\/tr>/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[0-9a-zA-Z\s]+)<\/td><\/tr>/',
        'exterior_color' => '/itemprop="color"\s+>(?<exterior_color>[a-zA-Z]+)<\/td><\/tr>/',
    ),
    
  /*  'data_capture_regx_full' => array(
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        'interior_color' => '/Interior Color<\/span>\s*.*\s*<span[^>]+>(?<interior_color>[^<]+)/',
        'trim' => '@"trim": "(?<trim>[^"]+)@',
    ),  */
    
    'next_page_regx' => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx' => '/<img onerror.+\ssrc="(?<img_url>[^"]*)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

  add_filter("filter_applewoodauto_field_price", "filter_applewoodauto_field_price", 10, 3);
    function filter_applewoodauto_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/Final Cash Price:.*<span itemprop="price"[^>]+>(?<price>[^\<]+)/';
       
                
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

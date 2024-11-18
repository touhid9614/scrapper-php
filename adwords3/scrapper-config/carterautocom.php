<?php
global $scrapper_configs;
$scrapper_configs["carterautocom"] = array( 
	'entry_points' => array(
        'new' => 'https://www.carterauto.com/new/',
        'used' => 'https://www.carterauto.com/used/'
    ),
   'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    //'use-proxy' => true,
    'refine'=>false,
    'proxy-area'        => 'FL',
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next-small'],
    'picture_prevs' => ['.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class=',
    'details_spliter' => '<input type="hidden" style="display:none;" id="vehicle_owner_dealer_id',
     'data_capture_regx' => array(
        'url' => '/<a itemprop="url" data-loc.*href="(?<url>[^"]+)"/',
        'year' => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer[^>]+>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model[^>]+>(?<model>[^\<]+)/',
        'price' => '/Price:.*<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'stock_number' => '/STK#\s*(?<stock_number>[^\s]+)/',
        
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[0-9]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
  add_filter("filter_carterautocom_field_price", "filter_carterautocom_field_price", 10, 3);
    function filter_carterautocom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP:.*<span itemprop="price"[^>]+>(?<price>[^\<]+)/';
         $cash_regex       =  '/Final Cash Price:.*<span itemprop="price"[^>]+>(?<price>[^\<]+)/';
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($cash_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Cash: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }

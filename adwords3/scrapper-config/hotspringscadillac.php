<?php
global $scrapper_configs;
 $scrapper_configs["hotspringscadillac"] = array( 
	 'entry_points' => array(
        'new'  => 'https://www.hotspringscadillac.com/VehicleSearchResults?search=new',
        'used' => 'https://www.hotspringscadillac.com/VehicleSearchResults?search=used',
     
      
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

     'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
     'details_start_tag' => '<ul each="cards">',
     'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
     'details_spliter'   => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
          
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',     
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/', 
           'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',     
           'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
           'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
           'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',  
           'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/', 
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
           'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/',
             'vin'              => '/key">VIN[^>]+>\s*[^>]+>\s*[^>]+>(?<vin>[^<]+)/'
       ),
        'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
    add_filter("filter_hotspringscadillac_next_page", "filter_hotspringscadillac_next_page",10,2);
    add_filter('filter_hotspringscadillac_field_price', 'filter_hotspringscadillac_field_price',10,3);
    add_filter("filter_hotspringscadillac_field_images", "filter_hotspringscadillac_field_images");
    
    function filter_hotspringscadillac_field_images($im_urls) {
    if(count($im_urls) < 2) { return array(); }
    return $im_urls;
}

    
    function filter_hotspringscadillac_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
        
       
    }  
     function filter_hotspringscadillac_field_price($price,$car_data,$spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/itemprop="price" if="prices.featuredPrice.isMsrp"\s*[^>]+>\s*(?<price>[^<]+)/';
        $market_regex     =  '/itemprop="price">(?<price>\$[0-9,]+)/';
              
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


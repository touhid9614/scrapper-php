<?php
global $scrapper_configs;
 $scrapper_configs["deweybarbercom"] = array( 
	 'entry_points' => array(
        'new'  => 'https://www.deweybarber.com/VehicleSearchResults?search=new',
        'used' => 'https://www.deweybarber.com/VehicleSearchResults?search=preowned',
 
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/',
     'use-proxy' => true,
     'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
     'picture_nexts'     => ['.arrow.single.next'],
     'picture_prevs'     => ['.arrow.single.prev'],
    
     'details_start_tag'    => '<ul each="cards">',
        'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
        'details_spliter'   => '<div class="deck" each="cards">',
        
        'data_capture_regx' => array(
       
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
       'data_capture_regx_full' => array(
            'stock_number'      => '/<span class="value" itemprop="sku">(?<stock_number>[^<]+)/',
            'transmission'      => '/<span class="value" itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
           'engine'            => '/<span class="value" itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'exterior_color'    => '/<span class="value" itemprop="color">(?<exterior_color>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
          
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
           'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/',
            'vin'           => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
       ),
         'next_page_regx'        => '/data-action="next" href="(?<next>[^"]+)"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
    );
    
  add_filter("filter_deweybarbercom_next_page", "filter_deweybarbercom_next_page",10,2);
    add_filter("filter_deweybarbercom_field_price", "filter_deweybarbercom_field_price", 10, 3);
    
    function filter_deweybarbercom_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
   

   
    function filter_deweybarbercom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        
        $msrp_regex   =  '/itemprop="price" value="[^>]+>(?<price>[^<]+)/';
      

                
        $matches = [];
        
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex msrp: {$matches['price']}");
        }
       
      
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }


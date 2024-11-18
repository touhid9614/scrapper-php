<?php
global $scrapper_configs;
 $scrapper_configs["delanochevybuickgmc"] = array( 
	  'entry_points' => array(
        'new'  => 'https://www.delanochevybuickgmc.com/VehicleSearchResults?search=new',
        'used' => 'https://www.delanochevybuickgmc.com/VehicleSearchResults?search=preowned',
     
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

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
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/', 
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
        'vin' => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^<]+)/',
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"\s* rel="next">Next/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
 
   
    
    
);

    
     add_filter("filter_delanochevybuickgmc_next_page", "filter_delanochevybuickgmc_next_page",10,2);
     
     
    function filter_delanochevybuickgmc_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    add_filter("filter_delanochevybuickgmc_field_images", "filter_delanochevybuickgmc_field_images");
    
    function filter_delanochevybuickgmc_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'noImage_large.png');
        });
    }
    
    add_filter("filter_delanochevybuickgmc_field_price", "filter_delanochevybuickgmc_field_price", 10, 3);
     function filter_delanochevybuickgmc_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP[^>]+>\s*[^>]+>(?<price>[^<]+)/';
       

                
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

    
   
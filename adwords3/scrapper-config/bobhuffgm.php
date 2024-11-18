<?php
global $scrapper_configs;

$scrapper_configs['bobhuffgm'] = array(
    'entry_points' => array(
        'new'  => 'http://www.bobhuffgm.com/VehicleSearchResults?search=new',
        'used' => 'http://www.bobhuffgm.com/VehicleSearchResults?search=preowned'
      
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used)-[0-9]{4}-\S+/i',

     'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
    'details_spliter'   => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
       // // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model'             => '/itemprop="model">(?<model>[^<]+)/',
        'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'drivetrain'        => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<drivetrain>[^<]+)/',
        'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'msrp'              => '/MSRP<\/span>\s*<span class="value " itemprop="price"[^>]+>(?<msrp>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'vin'               => '/data-vin\=\"(?<vin>[^\"]+)/',
        'kilometres'        => '/mileageFromOdometer[^\>]*\>[^\>]*\>(?<kilometres>[^\<]+)/',
        'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/',
        'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/',
        'description'       => '/repeat\=\"featureSpecs.entertainment.value\"\>[^\>]*\>(?<description>[^\>]+)/',
    ),
    'next_page_regx'        => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
    'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
    add_filter("filter_bobhuffgm_next_page", "filter_bobhuffgm_next_page",10,2);
     add_filter('filter_bobhuffgm_field_price', 'filter_bobhuffgm_field_price',10,3);
    
    function filter_bobhuffgm_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }

   
    
      function filter_bobhuffgm_field_price($price,$car_data,$spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP<\/span>\s*<span class="value " itemprop="price" value=[^>]+>(?<price>[^<]+)/';
       
              
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


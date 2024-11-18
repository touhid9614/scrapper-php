<?php
global $scrapper_configs;
 $scrapper_configs["johnlsullivanchevrolet"] = array( 
	  'entry_points' => array(
        'new'  => 'https://www.chevyworld.com/VehicleSearchResults?search=new',
        'used' => 'https://www.johnlsullivanchevrolet.com/used-cars/for-sale/'
      
     ),
      'vdp_url_regex'     => '/\/used\/[^\/]+\/[^\/]+\/[^\/]+\/[0-9]{4}-/i',
     
     
     'used'=>array(
     'vdp_url_regex'     => '/\/used\/[^\/]+\/[^\/]+\/[^\/]+\/[0-9]{4}-/i',
        'use-proxy' => true,
        
        'picture_selectors' => ['a[rel="carthumbs"]'],
        'picture_nexts'     => ['.mfp-arrow.mfp-arrow-right'],
        'picture_prevs'     => ['.mfp-arrow.mfp-arrow-left'],
        
        'details_start_tag' => '<div class="vehicle-search-results">',
        'details_end_tag'   => '<div class="vehicle-search-results-nav bottom">',
        'details_spliter'   => '<div class="panel panel-default vehicle-item',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock No:(?<stock_number>[^<]+)/',
            'year'          => '/class="year">(?<year>[0-9]{4})/',
            'make'          => '/itemprop="brand">(?<make>[^<]+)/',
            'model'         => '/<span class="model" [^>]+>(?<model>[^<]+)/',
            'trim'          => '/<span class="Car_Trim [^>]+>(?<trim>[^<]+)/',
            'price'         => '/Price<\/div>\s*<div[^>]+>(?<price>\$[0-9,]+)/',
            'engine'        => '/<span class="Car_Engine [^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/<span class="Car_Transmission [^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/span>\s*<span[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Miles:<\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/vehicle-title">\s*<a href="(?<url>[^"]+)/',    
        ),
        'data_capture_regx_full' => array(
           
        ),
        'next_page_regx'    => '/<li class="active">\s*.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" target="[^"]+" rel="carthumbs">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
         ),
     
     'new'   => array(
         
     'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
     'use-proxy' => true,
     'picture_selectors' => ['.item a img'],
     'picture_nexts'     => ['.mfp-arrow-right'],
     'picture_prevs'     => ['.mfp-arrow-left'],
     'details_start_tag' => '<ul each="cards">',
     'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
     'details_spliter'   => '<div class="deck" each="cards">',
      'data_capture_regx' => array(
          
          // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',
           'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
           'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
           'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
           'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
            'stock_number'      => '/vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
           'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/',
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
           'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/'
       ),
         'next_page_regx'        => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
         
        ),
          
);
 
 
 
    add_filter("filter_johnlsullivanchevrolet_next_page", "filter_johnlsullivanchevrolet_next_page",10,2);
    
    function filter_johnlsullivanchevrolet_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
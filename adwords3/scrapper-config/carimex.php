<?php
global $scrapper_configs;
 $scrapper_configs["carimex"] = array( 
	  'entry_points' => array(
              'used'  => 'https://www.carimex.ca/used/',
           
            
        ),
        'vdp_url_regex'     => '/\/vehicle\/[0-9]{4}-/i',
        'srp_page_regex'     => '/\/(?:new|used)\//i',
        'use-proxy' => true,
         'refine'=>false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span styl/',
            'year'                => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer\'[^>]+>[^>]+>(?<make>[^\s*<]+)/',
            'model'               => '/itemprop=\'model\'[^>]+>[^>]+>(?<model>[^\<]+)/',
            'price'               => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
             'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
            'drivetrain'          => '/itemprop="vehicleDrivetrain">(?<drivetrain>[^<]+)/',
            'vin'                 => '/itemprop="sku">(?<vin>[^<]+)/',
            
            
        ),
        'data_capture_regx_full' => array(        
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
            'fuel_type'           => '/Fuel type:[^>]+>[^>]+>\s*(?<fuel_type>[^<]+)/',
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">.*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
    );
    
    add_filter("filter_carimex_field_images", "filter_carimex_field_images");
    add_filter("filter_carimex_field_stock_number", "filter_carimex_field_stock_number");
    
    function filter_carimex_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'new_vehicles_images_coming.png');
        });
    }
    function filter_carimex_field_stock_number($stock_number)
    {
        if ( $stock_number == 'N/A') { $stock_number = ''; } 
        return $stock_number;
    }
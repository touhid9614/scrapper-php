<?php
global $scrapper_configs;
 $scrapper_configs["peacecountrytoyotaca"] = array( 
	'entry_points' => array(
             'used'  => 'https://www.peacecountrytoyota.ca/used/',
            'new'   => 'https://www.peacecountrytoyota.ca/new/',
            
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb li img'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div class="ajax-loading"',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span/',
            'year'                => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer[^>]+>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model[^>]+>(?<model>[^\<]+)/',
            'price'               => '/itemprop="price".*[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
             'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
            'drivetrain' => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
            //'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
            'vin'                 => '/\&vin=(?<vin>[^\&]+)/',
            'fuel_type'           => '/Fuel type:<\/td>[^>]+>\s*(?<fuel_type>[^<]+)/',
        'description'             => '/<meta name="description" content="(?<description>[^<]+)"/',
        ) ,
        'next_page_regx'    => '/<a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
    );
   add_filter("filter_peacecountrytoyotaca_field_images", "filter_peacecountrytoyotaca_field_images");
    
    function filter_peacecountrytoyotaca_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'new_vehicles_images_coming.png');
        });
    }
  
<?php
global $scrapper_configs;
 $scrapper_configs["erinmillsmazda"] = array( 
	  'entry_points' => array(
            'used'  => 'https://www.erinmillsmazda.ca/used/',
            'new'  => 'https://www.erinmillsmazda.ca/new/',
           
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'=>false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer wp"',
        'details_spliter'   => '<!-- vehicle-list-cell -->',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span\s*style=\'/',
            'year'                => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer[^>]+><var>(?<make>[^<\s*]+)/',
            'model'               => '/itemprop=\'model[^>]+><var>(?<model>[^<\s*]+)/',
            'trim'                => '/"trim":"(?<trim>[^"]+)"/',
            'price'               => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
           // 'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
             'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
             'vin'                 => '/VIN:[^>]+>[^>]+>(?<vin>[^\<]+)/',
            'drivetrain'           => '/Drivetrain:[^>]+>[^>]+>(?<drivetrain>[^\<]+)/',
        ),
        'data_capture_regx_full' => array(       
             'stock_number'        => '/Stock #:<\/td>\s*[^>]+>\s*(?<stock_number>[^\<]+)/',
            'make'                 => '/\&mk=(?<make>[^\&]+)/',
            'model'                => '/\&model=(?<model>[^\&]+)/',
            'description'           => '/meta name="description" content="(?<description>[^"]+)/',
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>\s*(?<kilometres>[0-9,]+)/',
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/data-src="(?<img_url>[^"]+)/'
    );
    
     add_filter("filter_erinmillsmazda_field_images", "filter_erinmillsmazda_field_images");
   
     function filter_erinmillsmazda_field_images($im_urls)
    {
         
         if(count($im_urls) < 2) 
        { 
            return array(); 
        }
         return array_filter($im_urls, function($im_url){
             return !endsWith($im_url, 'new_vehicles_images_coming.png');
         });
     }
  
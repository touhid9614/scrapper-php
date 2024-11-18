<?php
global $scrapper_configs;
 $scrapper_configs["ottawahonda"] = array( 
	 'entry_points' => array(
             'used'  => 'https://www.ottawahonda.com/used/',
            'new'   => 'https://www.ottawahonda.com/new/',
            
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb li img'],
        'picture_nexts'     => ['.glyphicon-chevron-right'],
        'picture_prevs'     => ['.glyphicon-chevron-left'],
        
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer',
        'details_spliter'   => '<div itemprop="ItemOffered"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)" history.*title="/',
            'year'                => '/itemprop=\'releaseDate\'>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer\'>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model\'>(?<model>[^\s]+)/',
            'price'               => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
            'stock_number'        => '/STK#\s*(?<stock_number>[^\/]+)/',
           
        ),
        'data_capture_regx_full' => array(   
              'kilometres'          => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
             'engine'              => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
            'exterior_color'     => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/', 
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
            'vin'                 => '/\&vin=(?<vin>[^\&]+)/',
        
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
    );
    
  
    add_filter("filter_ottawahonda_field_images", "filter_ottawahonda_field_images");
    function filter_ottawahonda_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }
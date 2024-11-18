<?php
global $scrapper_configs;
 $scrapper_configs["springhonda"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.springhonda.ca/new/',
            'used'  => 'https://www.springhonda.ca/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['li.next'],
        'picture_prevs'     => ['li.prev'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div id="bottom-footer">',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span style=/',
            'year'                => '/itemprop=\'releaseDate\'>(?<year>[^<]+)/',
            'make'                => '/itemprop=\'manufacturer\'>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model\'>(?<model>[^\<]+)/',
            'price'               => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>\s*(?<kilometres>[^<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
             'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
          
        ),
        'data_capture_regx_full' => array(        
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*src="(?<img_url>[^"]+)/'
    );
    
    add_filter("filter_springhonda_field_images", "filter_springhonda_field_images");
    
    function filter_springhonda_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }
  
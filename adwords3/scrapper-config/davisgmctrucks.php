<?php
global $scrapper_configs;
 $scrapper_configs["davisgmctrucks"] = array( 
	 'entry_points' => array(
            'new'  => 'https://www.davisgmctrucks.ca/new/',
            'used'  => 'https://www.davisgmctrucks.ca/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'=>false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div class="ajax-loading',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span/',
            'year'                => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer[^>]+>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model[^>]+>(?<model>[^\s*]+)/',
            'trim'                => '/"trim":"(?<trim>[^"]+)"/',
            'price'               => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
             'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
           
        ),
        'data_capture_regx_full' => array(                  
            'make'                => '/itemprop=\'manufacturer\'[^>]+>(?<make>[^\s]+)/',
            'model'               => '/itemprop=\'model\'[^>]+>(?<model>[^\s]+)/',
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/<img onerror=".*" data-src="(?<img_url>[^"]+)"\s*alt="/'
    );
    
    add_filter("filter_davisgmctrucks_field_images", "filter_davisgmctrucks_field_images");
   
    function filter_davisgmctrucks_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }
  
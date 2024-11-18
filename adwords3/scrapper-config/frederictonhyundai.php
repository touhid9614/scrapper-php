<?php

global $scrapper_configs;

$scrapper_configs['frederictonhyundai'] = array(
   'entry_points' => array(
            'new'   => 'https://www.frederictonhyundai.com/new/',
            'used'  => 'https://www.frederictonhyundai.com/used/',
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb li img'],
        'picture_nexts'     => ['.glyphicon-chevron-right'],
        'picture_prevs'     => ['.glyphicon-chevron-left'],
        
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span style=/',
            'year'                => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer\'[^>]+>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model\'[^>]+>(?<model>[^\<]+)/',
            'price'               => '/Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
             'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
           
        ),
        'data_capture_regx_full' => array(        
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/onerror="imgError\(this\)\;".*\s*src="(?<img_url>[^"]+)/'
    );
        add_filter("filter_frederictonhyundai_field_images", "filter_frederictonhyundai_field_images");
    
    function filter_frederictonhyundai_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'new_vehicles_images_coming.png');
        });
    }
  

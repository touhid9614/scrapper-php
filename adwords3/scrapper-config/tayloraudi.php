<?php
global $scrapper_configs;
 $scrapper_configs["tayloraudi"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.tayloraudi.ca/new/',
            'used'  => 'http://www.tayloraudi.ca/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['#imgList li img'],
        'picture_nexts'     => ['.glyphicon-chevron-right'],
        'picture_prevs'     => ['.glyphicon-chevron-left'],
     
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div class="ajax-loading" id="ajax-loader-img">',
        'details_spliter'   => '<!-- vehicle-list-cell -->',
        'data_capture_regx' => array(
            'stock_number'      => '/Stock #:<\/td><td class="[^"]+" itemprop="sku">(?<stock_number>[^<]+)/',
            'url'               => '/<a itemprop="url"\s*onclick="[^"]+" href="(?<url>[^"]+)"/',
            'title'             => '/<a class="btn btn-view-detail[^"]+" role="button"\s*onclick="[^"]+" href="[^"]+" title="View details (?<title>[^"]+)"/',
            'year'              => '/itemprop=\'releaseDate\'>(?<year>[0-9]{4})/',
            'make'              => '/itemprop=\'manufacturer\'>(?<make>[^\<]+)/',
            'model'             => '/itemprop=\'model\'>(?<model>[^\<]+)/',
            'price'             => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'kilometres'        => '/<span itemprop="mileageFromOdometer"[^>]+>(?<kilometres>[^<]+)/',
            'body_style'        => '/itemprop="bodyType">(?<body_style>[^<]+)/',
            'engine'            => '/itemprop="vehicleEngine">(?<engine>[^<]+)/',
            'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
            'exterior_color'    => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(
            'price'             => '/itemprop="price" content="(?<price>\$[0-9,]+)/',
            'interior_color'    => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
        ) ,
        'next_page_regx'    => '/var nextPageUrl = "(?<next>[^"]+)/',
        'images_regx'       => '/onerror="imgError\(this\);" src="(?<img_url>[^"]+)"/',
    );
    add_filter("filter_tayloraudi_field_images", "filter_tayloraudi_field_images");
    
    function filter_tayloraudi_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }
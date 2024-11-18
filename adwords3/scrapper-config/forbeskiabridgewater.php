<?php
    global $scrapper_configs;

    $scrapper_configs['forbeskiabridgewater'] = array(
        'entry_points' => array(
            'new'   => 'http://www.forbeskiabridgewater.ca/new/',
            'used'  => 'http://www.forbeskiabridgewater.ca/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy'         => true,
        'picture_selectors' => ['ul.thumb li'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div class="ajax-loading" id="ajax-loader-img">',
        'details_spliter'   => '<div itemprop="ItemOffered" itemscope itemtype="http://schema.org/Car"',
        'data_capture_regx' => array(
            'stock_number'      => '/Stock #:<\/td><td class="[^"]+" itemprop="sku">(?<stock_number>[^<]+)/',
            'url'               => '/<a itemprop="url"\s*onclick="[^"]+" href="(?<url>[^"]+)"/',
            'title'             => '/<a class="btn btn-view-detail[^"]+" role="button"\s*onclick="[^"]+" href="[^"]+" title="View details (?<title>[^"]+)"/',
            'year'              => '/<span itemprop=\'releaseDate\'>(?<year>[^<]+)/',
            'make'              => '/<span itemprop=\'manufacturer\'>(?<make>[^<]+)/',
            'model'             => '/<span itemprop=\'model\'>(?<model>[^<]+)/',
            'price'             => '/<span itemprop="price">(?<price>[^<]+)/',
            'kilometres'        => '/<span itemprop="mileageFromOdometer"[^>]+>(?<kilometres>[^<]+)/',
            'body_style'        => '/itemprop="bodyType">(?<body_style>[^<]+)/',
            'engine'            => '/itemprop="vehicleEngine">(?<engine>[^<]+)/',
            'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
            'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'price'             => '/itemprop="price" content="(?<price>\$[0-9,]+)/',
            'interior_color'    => '/itemprop="vehicleInteriorColor">\s*(?<interior_color>[^<]+)/'
        ) ,
        'next_page_regx'    => '/ var nextPageUrl = "(?<next>[^"]+)/',
        'images_regx'       => '/onerror="imgError\(this\);" src="(?<img_url>[^"]+)"/',
    );
    add_filter("filter_forbeskiabridgewater_field_images", "filter_forbeskiabridgewater_field_images");
    
    function filter_forbeskiabridgewater_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }
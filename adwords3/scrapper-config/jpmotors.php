<?php
    global $scrapper_configs;

    $scrapper_configs['jpmotors'] = array(
        'entry_points' => array(
            'used'  => 'http://www.jpmotors.com/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        //'use-proxy'         => true,
        'proxy-area'        => 'FL',
        'picture_selectors' => ['.maincontent .slideshow .thumb img'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div class="ajax-loading" id="ajax-loader-img">',
        'details_spliter'   => '<div itemprop="ItemOffered" itemscope itemtype',
        'data_capture_regx' => array(
            'stock_number'      => '/Stock #:<\/td><td class="[^"]+" itemprop="sku">(?<stock_number>[^<]+)/',
            'url'               => '/<a itemprop="url"\s*onclick="[^"]+" href="(?<url>[^"]+)"/',
            'title'             => '/<a class="btn btn-view-detail[^"]+" role="button"\s*onclick="[^"]+" href="[^"]+" title="View details (?<title>[^"]+)"/',
            'year'              => '/itemprop=\'releaseDate\'>(?<year>[^<]+)/',
            'make'              => '/itemprop=\'manufacturer\'>(?<make>[^<]+)/',
            'model'             => '/itemprop=\'model\'>(?<model>[^<]+)/',
            'price'             => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'kilometres'        => '/<span itemprop="mileageFromOdometer"[^>]+>(?<kilometres>[^<]+)/',
            'body_style'        => '/itemprop="bodyType">(?<body_style>[^<]+)/',
            'engine'            => '/itemprop="vehicleEngine">(?<engine>[^<]+)/',
            'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
            'exterior_color'    => '/itemprop="color"\s*>(?<exterior_color>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'interior_color'    => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^<]+)/'
        ) ,
        'next_page_regx'    => '/var nextPageUrl = "(?<next>[^"]+)/',
        'images_regx'       => '/<img onerror="imgError\(this\);" src="(?<img_url>[^"]+)"/',
    );
    
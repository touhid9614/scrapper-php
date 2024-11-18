<?php
    global $scrapper_configs;

    $scrapper_configs['peakmangroup'] = array(
        'entry_points'   => array(
            'new'     => 'http://peakmangroup.ca/mylistings.html/'
        ),
        'vdp_url_regex'     => '/\/mylistings.html\//i',
        
        'use-proxy' => true,
        //'picture_selectors' => ['#slideshow_1 .slide','.pswp__item'],
        //'picture_nexts'     => ['.pswp__button pswp__button--arrow--right'],
        //'picture_prevs'     => ['.pswp__button pswp__button--arrow--left'],
        
        'details_start_tag' => '<div class="mrp-listing-results-sub-categories">',
        'details_end_tag'   => '<div class="outer-footer">',
        'details_spliter'   => '<li class="mrp-listing-result',
        'data_capture_regx' => array(
            'url'           => '/mrp-listing-details-link">\s*<a title="[^"]+"\s*href="(?<url>[^"]+)/',
            'price'         => '/mrp-listing-price-container">(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Floor Area:<\/dt>\s*<dd[^>]*><span><span[^>]+>(?<kilometres>[^<]+)/',//Square feet
            'stock_number'  => '/MLS&reg; Num:<\/dt>\s*<dd[^>]+><span>(?<stock_number>[^<]+)/',
        ),
        'data_capture_regx_full' => array(     
            'year'              => '/Year Built:<\/dt><dd[^>]+>(?<year>[0-9]{4})/',
            'make'              => '/mrp-listing-title">(?<model>[0-9]+)\s*(?<make>[^\n]+)/',
            'model'             => '/mrp-listing-title">(?<model>[0-9]+)\s*(?<make>[^\n]+)/',
            'body_style'        => '/Number of bedrooms:<\/dt>\s*<dd[^>]*>(?<body_style>[^<]+)/',    //Bedrooms
            'engine'            => '/Property Type:<\/dt>\s*<dd[^>]*>(?<engine>[^<]+)/',             //Property Type                                                           //Property Type
            
        ) ,
        'next_page_regx'    => '/<a href="[^"]+"\s*title="[^"]+"\s*class="small-number current"\s*[^\/]+\/a><a href="(?<next>[^"]+)/',
        'images_regx'       => '/mrp-listing-photo-thumb"\s*>[^\n]+\s*data-full-src="(?<img_url>[^"]+)/',
        
    );

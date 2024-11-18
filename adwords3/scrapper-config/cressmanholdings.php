<?php
    global $scrapper_configs;

    $scrapper_configs['cressmanholdings'] = array(
        'entry_points' => array(
            'new'  => 'http://cressmanholdings.com/available-rentals/'
        ),
        'vdp_url_regex'     => '/\/portfolio-item\//i',
        //'ty_url_regex'      => '/\/thankYou.do/i',
        'use-proxy'         => true,
        'refine'            => false,
        'picture_selectors' => ['.av-fixed-size .av-masonry-image-container img'],
        'picture_nexts'     => ['.mfp-arrow-right'],
        'picture_prevs'     => ['.mfp-arrow-left'],
        'details_start_tag'   => '<div class=\' grid-sort-container',
        'details_end_tag'     => '<footer class=\'container_wrap socket_color\'',
        'details_spliter'     => 'class=\' grid-entry',
        
        'data_capture_regx' => array(
            'url'               => '/itemprop="headline"\s*><a href=\'(?<url>[^\']+)\' title=\'(?<title>(?<model>[0-9]{1,4} [A-Z]{1})\s*(?<make>[^0-9]*))(?<body_style>[^\$]+)(?<price>\$[0-9,]+)/',
            'title'             => '/itemprop="headline"\s*><a href=\'(?<url>[^\']+)\' title=\'(?<title>(?<model>[0-9]{1,4} [A-Z]{1})\s*(?<make>[^0-9]*))(?<body_style>[^\$]+)(?<price>\$[0-9,]+)/',
            'make'              => '/itemprop="headline"\s*><a href=\'(?<url>[^\']+)\' title=\'(?<title>(?<model>[0-9]{1,4} [A-Z]{1})\s*(?<make>[^0-9]*))(?<body_style>[^\$]+)(?<price>\$[0-9,]+)/',
            'model'             => '/itemprop="headline"\s*><a href=\'(?<url>[^\']+)\' title=\'(?<title>(?<model>[0-9]{1,4} [A-Z]{1})\s*(?<make>[^0-9]*))(?<body_style>[^\$]+)(?<price>\$[0-9,]+)/',
            'price'             => '/itemprop="headline"\s*><a href=\'(?<url>[^\']+)\' title=\'(?<title>(?<model>[0-9]{1,4} [A-Z]{1})\s*(?<make>[^0-9]*))(?<body_style>[^\$]+)(?<price>\$[0-9,]+)/',
            'body_style'        => '/itemprop="headline"\s*><a href=\'(?<url>[^\']+)\' title=\'(?<title>(?<model>[0-9]{1,4} [A-Z]{1})\s*(?<make>[^0-9]*))(?<body_style>[^\$]+)(?<price>\$[0-9,]+)/'       //Bedrooms+Bathrooms
        
        ),
        'data_capture_regx_full' => array(
            
            ),
        'images_regx'       => '/style="background-image: url\((?<img_url>[^\)]+)/',
    );

    
<?php

    global $scrapper_configs;

    $scrapper_configs['carsoncarp'] = array(
        'entry_points' => array(
            'used' => 'https://carsoncarp.ca/inventory/'
        ),
        'vdp_url_regex'     => '/\/[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.multi-list>li'],
        'picture_nexts'     => ['.carousel__button--next'],
        'picture_prevs'     => ['.carousel__button--previous'],
        
        'details_start_tag' => ' <article class="rule--top">',
        'details_end_tag'   => ' <footer ',
        'details_spliter'   => '<div id="item-',
        'data_capture_regx' => array(
            'url'           => '/<a title="(?<title>[^"]+)" href="(?<url>[^"]+)/',
            'title'         => '/<a title="(?<title>[^"]+)" href="(?<url>[^"]+)/',
            'year'          => '/title="\s*(?<year>[^\s]*)\s*(?<make>[^\s]*)\s*(?<model>[^\s]*)"/',
            'make'          => '/title="\s*(?<year>[^\s]*)\s*(?<make>[^\s]*)\s*(?<model>[^\s]*)"/',
            'model'         => '/title="\s*(?<year>[^\s]*)\s*(?<make>[^\s]*)\s*(?<model>[^\s]*)"/',
            'price'         => '/itemprop="price">[^\n]+\s*<strong[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/(?<kilometres>[0-9,]+)<\/strong>\s*<span[^>]+>KM/',
            
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@<span itemprop="brand">(?<make>[^<]+)@',
            'model'         => '@<span itemprop="model">(?<model>[^<]+)@',
            'stock_number'  => '/Stock No:\s*(?<stock_number>[^<]+)/',
            'engine'        => '/Engine Type<\/strong><\/dt>\s*[^\n]+\s*[^\n]+\s*<li>(?<engine>[^\&]+)/',
            'body_style'    => '/Body Style<\/strong><\/dt>\s*[^\n]+\s*[^\n]+\s*<li>(?<body_style>[^\&]+)/',
            'transmission'  => '/Transmission<\/strong><\/dt>\s*[^\n]+\s*[^\n]+\s*<li>(?<transmission>[^\&]+)/',
            'exterior_color'=> '/Exterior Colour<\/strong><\/dt>\s*[^\n]+\s*[^\n]+\s*<li>(?<exterior_color>[^\&]+)/',
            'interior_color'=> '/Interior Colour<\/strong><\/dt>\s*[^\n]+\s*[^\n]+\s*<li>(?<interior_color>[^\&]+)/'
        ) ,
       // 'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<img class="js-lazy" src="(?<img_url>[^"]+)/'
    );


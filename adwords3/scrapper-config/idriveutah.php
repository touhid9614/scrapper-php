<?php
global $scrapper_configs;
 $scrapper_configs["idriveutah"] = array( 
	'entry_points'  => array(
            'new'  => 'https://www.idriveutah.com/used-trucks-orem-ut',
           // 'used' => 'http://www.heritageromehonda.com/used-cars-rome-ga',
        ),
        'vdp_url_regex'     => '/\/vehicle-details\//i',
        'ty_url_regex'      => '/form-action=success-/',
        //'iframe_url_match'  => '1',
        'use-proxy' => true,
        'picture_selectors' => ['.item'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="vehicle-page"',
        'details_end_tag'   => '<div class="com-inventory-listing-pagination',
        'details_spliter'   => '<div class="action-buttons hidden-list visible-on-xs">',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/<meta itemprop="price" content="(?<price>[^"]+)/',
           // 'body_style'    => '/<div class="spec-td body-value">(?<body_style>[^<]+)/',
            'engine'        => '/class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
            'transmission'  => '/class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
           // 'exterior_color'=> '/<div class="spec-td exterior-color-value">(?<exterior_color>[^<]+)/',
           // 'interior_color'=> '/<div class="spec-td interior-color-value">(?<interior_color>[^<]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'kilometres'    => '/Mileage:[\s\S]*?<span class="value">(?<kilometres>[^<]+)/',
            'trim'          => '@Trim:</strong></span>\s*<span class="value">(?<trim>[^<]+)@',
            'body_style'    => '@Body:<\/[^\n]+\s*<span[^>]+>(?<body_style>[^<]+)@',
        ),
        'next_page_regx'    => '/class="active">[^>]+>[^>]+>[^>]+>[^>]+>\s*<a href="(?<next>[^"]+)/',
        'images_regx'       => '/<li><img (?:data-lazy|src)="(?<img_url>[^"]+)" alt="/'
    );

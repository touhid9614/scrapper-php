<?php
global $scrapper_configs;
 $scrapper_configs["barlowmotors"] = array( 
	'entry_points'  => array(
            'used'  => 'https://www.barlowmotors.com/used-cars-calgary-ab',
           // 'used' => 'http://www.heritageromehonda.com/used-cars-rome-ga',
        ),
        'vdp_url_regex'     => '/\/vehicle-details\//i',
        'ty_url_regex'      => '/form-action=success-/',
        //'iframe_url_match'  => '1',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb-item.thumb-image div img'],
        'picture_nexts'     => ['.glyphicon-menu-right'],
        'picture_prevs'     => ['.glyphicon-menu-left'],
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
            'exterior_color'=> '/class="spec-td exterior-color-value">(?<exterior_color>[^<]+)/',
           // 'interior_color'=> '/<div class="spec-td interior-color-value">(?<interior_color>[^<]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'kilometres'    => '/Mileage:[\s\S]*?<span class="value">(?<kilometres>[^<]+)/',
            'trim'          => '@Trim:</strong></span>\s*<span class="value">(?<trim>[^<]+)@',
            'body_style'    => '@Body:<\/[^\n]+\s*<span[^>]+>(?<body_style>[^<]+)@',
            'vin'           => '/VIN #:<\/strong><\/span>\s*[^>]+>(?<vin>[^<]+)/',
            'drivetrain'    => '/Drive:<\/strong><\/span>\s*[^>]+>(?<drivetrain>[^<]+)/',
            'fuel_type'     => '/Fuel:<\/strong><\/span>\s*[^>]+>(?<fuel_type>[^<]+)/',
            'kilometres'    => '/Kilometers:<\/strong><\/span>\s*[^>]+>(?<kilometres>[^<]+)/',
            'exterior_color'=> '/Body:<\/[^\n]+\s*<span[^>]+>(?<exterior_color>[^<]+)/',
            
        ),
        'next_page_regx'    => '/class="active">[^>]+>[^>]+>[^>]+>[^>]+>\s*<a href="(?<next>[^"]+)/',
        'images_regx'       => '/<img (?:data-lazy|src)="[^"]+".* data-preview="(?<img_url>[^"]+)"/'
    );

<?php
    global $scrapper_configs;

    $scrapper_configs['cityhonda'] = array(
        'entry_points' => array(
            'new'   => 'http://www.steelehonda.com/new-honda-st-johns-nl',
            'used'  => 'http://www.steelehonda.com/used-cars-st-johns-nl'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/',
        'use-proxy' => true,
        
        'picture_selectors' => ['.mod-vehicle-gallery .images ul li.active'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<div class="c-vehicles grid">',
        'details_end_tag'   => '<div class="com-inventory-listing-pagination row',
        'details_spliter'   => '<div class="vehicle"',
        'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/<span class="price-value" itemprop="price">(?<price>[^<]+)/',           
            'transmission'  => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'body_style' => 'Body:<\/strong><\/span>\s*<span\s*class="value">(?<body_style>[^<]+)',
            'trim'       => 'Trim:<\/strong><\/span>\s*<span\s*class="value">(?<trim>[^<]+)'
        ),
        'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/',
        
    );

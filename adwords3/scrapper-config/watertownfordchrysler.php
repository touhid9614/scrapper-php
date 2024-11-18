<?php
    global $scrapper_configs;

    $scrapper_configs['watertownfordchrysler'] = array(
        'entry_points' => array(
            'new'   => 'https://www.watertownfordchrysler.com/new-cars-watertown-sd',
            'used'  => 'https://www.watertownfordchrysler.com/used-cars-watertown-sd',
           // 'certified' => 'https://www.watertownfordchrysler.com/certified-used-cars-watertown-sd'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/form-action=success-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="c-vehicles grid">',
        'details_end_tag'   => '<div class="com-inventory-listing-pagination row',
        'details_spliter'   => '<div class="vehicle"',
        'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        'must_not_contain_regex'=> '/<div class="isSold">[^<]+<\/div>/',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         => '/itemscope [^>]+>\s*<meta\s*itemprop="name"\s*content="(?<title>[^"]+)"/>/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/<meta itemprop="price" content="(?<price>[^"]+)/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'transmission'  => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'kilometres'    => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
            'certified'     => '/alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            
            'trim'          => '/Trim:.*\s*<span class="value">(?<trim>[^ <]+)/',
            'body_style'    => '/Body:.*\s*<span class="value">(?<body_style>[^<]+)/',
            'interior_color'=> '/Interior:.*\s*<span class="value">(?<interior_color>[^ <]+)/',
            
           
        ),
        'next_page_regx'    => '/<li id="il-pagination-element-[0-9]+" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<li><img src="(?<img_url>[^\"]+)" alt="[^"]+" class="img-responsive" itemprop="image"/'
    );
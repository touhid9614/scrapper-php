<?php

    global $scrapper_configs;

    $scrapper_configs['lexusofsaintjohn'] = array(
        'entry_points' => array(
            'new'    => 'https://lexusofsaintjohn.com/new-cars-saint-john-nb',
            'used'   => 'https://lexusofsaintjohn.com/used-cars-saint-john-nb'
        ),
         'vdp_url_regex'     => '/\/vehicle-details\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="vehicles-container list-view">',
        'details_end_tag'   => '<div class="inventory-pagination">',
        'details_spliter'   => '<div class="vehicle"',
        'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/<meta itemprop="price" content="(?<price>[^"]+)/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'engine'        => '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
            'transmission'  => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'kilometres'    => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'trim'          => '/Trim:.*\s*<span class="value">(?<trim>[^ <]+)/',
            'body_style'    => '/Body:.*\s*<span class="value">(?<body_style>[^<]+)/',
            'interior_color'=> '/Interior:.*\s*<span class="value">(?<interior_color>[^<]+)/'
        ),
        'next_page_regx'    => '/active\s+"\s*[^\n]+\s*<a[^\n]+\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/thumb-preview">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
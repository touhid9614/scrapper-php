<?php

 global $scrapper_configs;

    $scrapper_configs['heritageromehonda'] = array (
        'entry_points'  => array(
            'new'  => 'https://www.heritageromehonda.com/new-honda-rome-ga',
            'used' => 'https://www.heritageromehonda.com/used-cars-rome-ga',
        ),
        'vdp_url_regex'     => '/\/vehicle-details\//i',
        'ty_url_regex'      => '/form-action=success-/',
        //'iframe_url_match'  => '1',
        'use-proxy' => true,
        'picture_selectors' => ['.item'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="vehicle-page"',
        'details_end_tag'   => '<div class="quick-preview-wrapper">',
        'details_spliter'   => '<div class="vehicle clearfix"',
        'data_capture_regx' => array(
            'stock_number'  => '/<div class="spec-td stock-value">(?<stock_number>[^<]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/<div class="price js-price-info"\s*[^$]+(?<price>[^<]+)/',
            'body_style'    => '/<div class="spec-td body-value">(?<body_style>[^<]+)/',
            'engine'        => '/<div class="spec-td engine-value">(?<engine>[^<]+)/',
            'transmission'  => '/<div class="spec-td trans-value">(?<transmission>[^<]+)/',
            'exterior_color'=> '/<div class="spec-td exterior-color-value">(?<exterior_color>[^<]+)/',
            'interior_color'=> '/<div class="spec-td interior-color-value">(?<interior_color>[^<]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'kilometres'    => '/Mileage:[\s\S]*?<span class="value">(?<kilometres>[^<]+)/',
            
            'trim'          => '@Trim:</strong></span>\s*<span class="value">(?<trim>[^<]+)@',
            'body_style'    => '@Body:<\/[^\n]+\s*<span[^>]+>(?<body_style>[^<]+)@',
        ),
        'next_page_regx'    => '/class="active"><a href=[\s\S]*?<li id="il-pagination-element.*<a href="(?<next>[^"]+)/',
        'images_regx'       => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
    );

<?php
    global $scrapper_configs;

    $scrapper_configs['sportlinepower'] = array(
        'entry_points' => array(
            'new'  => 'https://www.sportlinepower.com/search/inventory/availability/In%20Stock/usage/New',
            'used' => 'https://www.sportlinepower.com/search/inventory/availability/In%20Stock/usage/Used'
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.slick-slide'],
        'picture_nexts'     => ['.slick-next','.mfp-arrow .mfp-arrow-right'],
        'picture_prevs'     => ['.slick-prev','.mfp-arrow .mfp-arrow-left'],
        
        'details_start_tag' => '<div class="search-results-list">',
        'details_end_tag'   => '<div class="sft-footer">',
        'details_spliter'   => '<div class="panel panel-default search-result">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #<\/strong>\s*.*\s*<td[^>]+>\s*(?<stock_number>[^<]+)/',
            'year'          => '/data-model-year>(?<year>[0-9]{4})/',
            'make'          => '/data-model-brand>(?<make>[^<]+)/',
            'model'         => '/data-model-name>(?<model>[^<]+)/',
            'price'         => '/itemprop="price">\s*(?<price>\$[0-9,]+)/',
            'body_style'    => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
            'exterior_color'=> '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',
            'kilometres'    => '/Usage<\/strong>\s*.*\s*<td[^>]+>\s*(?<kilometres>[0-9]+ Miles)/',
            'url'           => '/<a href="(?<url>[^"]+)" .*>View Details/'
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        ),
        
        'next_page_regx'    => '/<li class="active">\s*<a href="[^"]+">[^\n]+\s*<\/li>\s*<li [^>]+>\s*<a href="(?<next>[^"]+)/',
        'images_regx'       => '/em">\s*<img src="[^\?]+\?img=(?<img_url>[^\&]+)/',
        'images_fallback_regx'  => '/unit-image-container">\s*<a href="(?<img_url>[^"]+)/'
    );
    add_filter("filter_sportlinepower_field_images", "filter_sportlinepower_field_images");
    
    function filter_sportlinepower_field_images($im_urls)
    {
       $retval = array();
       slecho(implode('|', $im_urls));
        foreach($im_urls as $im_url) {
            $retval[] = str_replace('http://www.sportlinepower.com/inventory/','',rawurldecode($im_url));
           // $retval[] = str_replace('&amp;', '&', $url);
        }
        slecho(implode('|', $retval));
        return $retval;
    }
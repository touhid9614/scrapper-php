<?php
    global $scrapper_configs;

    $scrapper_configs['flamantrailers'] = array(
        'entry_points' => array(
            'new'   => 'https://flamantrailers.com/on-our-lot/filter/trailer-type/new.html',
            'used'  => 'https://flamantrailers.com/on-our-lot/filter/trailer-type/used.html'
        ),
        'vdp_url_regex'     => '/\/on-our-lot\/([0-9]{4}-)?[^-]+-/i',
        
        'use-proxy'         => true,
        'refine'            => false,
        'picture_selectors' => ['.product-image-thumbs a'],
        'picture_nexts'     => ['.featherlight-next'],
        'picture_prevs'     => ['.featherlight-previous'],
        
        'details_start_tag' => '<div id="catalog-listing">',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div class="col-sm-6 col-md-4 clearfix product-list-item">',
        
        'data_capture_regx' => array(
            'title'         => '/product-name">\s*(?<title>[^<]+)/',
            'price'         => '/<span class="price">(?<price>\$[0-9,.]+)/',
            'url'           => '/<a href="(?<url>[^"]+).* class="product-image">/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Serial No:<\/div>\s*<div[^>]+>(?<stock_number>[^<]+)/',
            'year'          => '/Year:<\/div>\s*<div[^>]+>(?<year>[0-9]{4})/',
            'make'          => '/Make:<\/div>\s*<div[^>]+>(?<make>[^<]+)/',
            'model'         => '/Model:<\/div>\s*<div[^>]+>(?<model>[^<]+)/'
        ) ,
        'next_page_regx'    => '/<li class="current">[^\n]+\s*<li><a href="(?<next>[^"]+)/',
        'images_regx'       => '/<a id="image-[0-9]+" href="(?<img_url>[^"]+)/',
    );

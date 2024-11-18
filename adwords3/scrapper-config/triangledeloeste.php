<?php
    global $scrapper_configs;

    $scrapper_configs['triangledeloeste'] = array(
        'entry_points' => array(
            'new'   => 'http://www.triangledeloeste.com/new-cars.aspx',
            'used'  => 'http://www.triangledeloeste.com/used-cars.aspx'
        ),
        'vdp_url_regex'     => '/\/detail-[0-9]{4}-/i',
        
        'use-proxy'         => true,
        
        'picture_selectors' => [],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        
        'details_start_tag' => '<div class="col-md-9 nopadding clearfix">',
        'details_end_tag'   => '<div id="disclaimer" class="clearfix">',
        'details_spliter'   => '<div class="srp-vehicle-block',
        
        'data_capture_regx' => array(
            'stock_number'      => '/Stock #:<\/strong>\s*(?<stock_number>[^<]+)/',
            'year'              => '/ebiz-vdp-title"><a href="[^"]+">(?<year>[0-9]{4})\s*/',
            'make'              => '/ebiz-vdp-title"><a href="[^"]+">[0-9]{4}\s*(?<make>[^\s]+)\s*/',
            'model'             => '/ebiz-vdp-title"><a href="[^"]+">[0-9]{4}\s*[^\s]+\s*(?<model>[^<]*)/',
            'price'             => '/Internet Price<\/div>\s*<a[^>]+><h4[^>]+>(?<price>\$[0-9,]+)/',
            'engine'            => '/Engine:<\/strong>\s*(?<engine>[^<]+)/',
            'transmission'      => '/Transmission:<\/strong>\s*(?<transmission>[^<]+)/',
            'kilometres'        => '/Miles:<\/strong>\s*(?<kilometres>[^<]+)/',
            'exterior_color'    => '/Exterior:<\/strong>\s*(?<exterior_color>[^<]+)/',
            'interior_color'    => '/Interior:<\/strong>\s*(?<interior_color>[^<]+)/',
            'url'               => '/ebiz-vdp-title"><a href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Body Style :(?<body_style>[^<]+)/',
            'trim'          => '/InventoryTrimParam:\s*\'(?<trim>[^\']+)/',
            'make'          => '/InventoryMakeParam:\s*\'(?<make>[^\']+)/',
            'model'          => '/InventoryModelParam:\s*\'(?<model>[^\']+)/'
        ) ,
        'next_page_regx'    => '/<li class="active">[^\n]+\s*<li><a href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" data-lightbox="gallery-item".*/',
    );

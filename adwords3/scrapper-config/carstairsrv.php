<?php
    global $scrapper_configs;

    $scrapper_configs['carstairsrv'] =  array(
        'entry_points' => array(
            'new'   => [
                'http://www.carstairsrv.com/new-rvs-for-sale',
                'http://www.carstairsrv.com/motorhomes-for-sale',
                'http://www.carstairsrv.com/discount-rvs-for-sale',
                'http://www.carstairsrv.com/fifth-wheels-for-sale',
                'http://www.carstairsrv.com/travel-trailers-for-sale',
                'http://www.carstairsrv.com/toy-haulers-for-sale'
            ],
            'used'  => [
                'http://www.carstairsrv.com/used-rvs-for-sale'
            ]
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/contact-confirmation/i',
        'use-proxy'         => true,
        'refine'            => false,
        'picture_selectors' => ['.ug-thumb-wrapper .ug-thumb-overlay'],
        'picture_nexts'     => ['.ug-slider-control.ug-arrow-right.ug-skin-alexis'],
        'picture_prevs'     => ['.ug-slider-control.ug-arrow-left.ug-skin-alexis'],
        
        'details_start_tag' => '<div id="inventory-listing"',
        'details_end_tag'   => '<footer class="container-fluid">',
        'details_spliter'   => '<div class="row inventory-box">',
        'data_capture_regx' => array(
            'url'               => '/<h3 class="inventory-hd"><a href="(?<url>[^\"]+)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'      => '/<strong>Stock#<\/strong><\/div> <div[^>]+>(?<stock_number>[^<]+)/',
            'year'              => '/<strong>Year<\/strong><\/div> <div[^>]+>(?<year>[^<]+)/',
            'make'              => '/<strong>Manufacturer<\/strong><\/div> <div[^>]+>(?<make>[^<]+)/',
            'model'             => '/<strong>Model<\/strong><\/div> <div[^>]+>(?<model>[^<]+)/',
            'trim'              => '/<strong>Trim<\/strong><\/div> <div[^>]+>(?<trim>[^<]+)/',
            'stock_type'        => '/<strong>Condition<\/strong><\/div> <div[^>]+>(?<stock_type>[^<]+)/',
            'body_style'        => '/<strong>Class <\/strong><\/div><div[^>]+>(?<body_style>[^<]+)/',
            'exterior_color'    => '/<strong>Exterior Color <\/strong><\/div><div[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'    => '/<strong>Interior Color <\/strong><\/div><div[^>]+>(?<interior_color>[^<]+)/',
            'price'             => '/<div class="price-label">Selling Price<\/div> <div class="price-value">(?<price>[^<]+)/',
        ),
        'next_page_regx'    => '/<a href="(?<next>[^\"]+)" aria-label="Next">/',
        'images_regx'       => '/<img alt="" src="[^\"]+" data-image="(?<img_url>[^"]+)"/'
    );
    
    add_filter("filter_carstairsrv_field_stock_type", "filter_carstairsrv_field_stock_type");

    function filter_carstairsrv_field_stock_type($stock_type) {
        return strtolower($stock_type);
    }
<?php

    global $scrapper_configs;

    $scrapper_configs['weberexclusive'] = array(
        'entry_points' => array(
            'used'  => 'http://www.weberexclusive.com/inventory/search?stock_type=USED'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/(?:used-sales|new-sales|test-drive)\/success/i',
        'details_start_tag' => '<div class="smi-srp-right-column">',
        'details_end_tag'   => '<div class="srp-disclaimer">',
        'details_spliter'   => '<span itemscope itemtype="http://schema.org/Product">',
        'data_capture_regx' => array(
            'stock_number'  => '/<span itemprop="productID">(?<stock_number>[^<]+)/',
            'title'         => '/<h4 itemprop="name">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'year'          => '/<h4 itemprop="name">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'make'          => '/<h4 itemprop="name">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'model'         => '/<h4 itemprop="name">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'price'         => '/<span class="current-price"\s*itemprop="price"\s*content="(?<price>[^"]+)/',
            'engine'        => '/Engine:&nbsp;\s*(?<engine>[^\s<]+)/',
            'transmission'  => '/Transmission: (?<transmission>[^<]+)/',
            'exterior_color'=> '/<span itemprop="color">(?<exterior_color>[^<]+)/',
            'kilometres'    => '/<li>Odometer: (?<kilometres>[^<]+)/',
            'url'           => '/<a itemprop="url" href="(?<url>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '@itemdescription: "(?<body_style>[^"]+)@'
        ),
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="openphoto">/',
        'next_page_regx'    => '/<li class="active"><a href="[^"]+">[^<]+<\/a><\/li>\s*<li><a href="(?<next>[^"]+)"/'
    );

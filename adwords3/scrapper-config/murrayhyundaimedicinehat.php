<?php

global $scrapper_configs;

$scrapper_configs['murrayhyundaimedicinehat'] = array(
    'entry_points'      => array(
        'new'  => 'http://www.murrayhyundaimedicinehat.com/new-inventory/index.htm',
        'used' => 'http://www.murrayhyundaimedicinehat.com/used-inventory/index.htm',
    ),
    'use-proxy'         => true,
    'picture_selectors' => ['.imageViewer'],
    'picture_nexts'     => ['.imageScrollNext', '.next'],
    'picture_prevs'     => ['.imageScrollPrev', '.previous'],
    'new'               => array(
        'details_start_tag'      => '<ul class="inventoryList data full">',
        'details_end_tag'        => '<div class="ft">',
        'details_spliter'        => '<div class="item-compare">',
        'data_capture_regx'      => array(
            'stock_number'   => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'price'          => '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/',
            'body_style'     => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'         => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'     => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'            => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        ),
        'data_capture_regx_full' => array(
            'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        ),
        'next_page_regx'         => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'            => '/<li>\s*<a href="(?<img_url>\/\/pictures.dealer.com\/[^"]+)" class="">/',
    ),
    'used'              => array(
        'details_start_tag'      => '<ul class="inventoryList data full">',
        'details_end_tag'        => '<div class="ft">',
        'details_spliter'        => '<div class="item-compare">',
        'must_contain_regx'      => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'data_capture_regx'      => array(
            'stock_number'   => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'price'          => '/class="value[^>]+>(?<price>[^<]+)/',
            'body_style'     => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'         => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'     => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'            => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        ),
        'data_capture_regx_full' => array(
            'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        ),
        'next_page_regx'         => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'            => '/<li>\s*<a href="(?<img_url>\/\/pictures.dealer.com\/[^"]+)" class="">/',
    ),
);

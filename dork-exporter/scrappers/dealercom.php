<?php

global $site_scrappers;

$site_scrappers['dealercom'] = array(
    'use-proxy' => true,
    'details_start_tag' => '<ul class="inventoryList data full">',
    'details_end_tag'   => '<div class="ft">',
    'details_spliter'   => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price'         => '/class="value[^>]+>(?<price>[^<]+)/',
        'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
        'engine'        => '/Engine:<\/dt> <dd>(?<engine>[^<]+)/',
        'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'data_capture_regx_full' => array(
        'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/'
    ) ,
    'options_start_tag' => '<dt>Options</dt>',        
    'options_end_tag'   => '</dd>',        
    'options_regx'      => '/<li><span>(?<option>[^<]+)/',        
    'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx'       => '/<li>\s<a href="(?<img_url>[^\"]+)"/'
);

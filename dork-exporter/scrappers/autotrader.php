<?php

global $site_scrappers;

$site_scrappers['autotrader'] = array(
    'use-proxy' => true,
    'details_start_tag' => '<ul class="inventoryList data full',
    'details_end_tag'   => '<div class="ft">',
    'details_spliter'   => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price'         => '/.*class="value[^>]+>(?<price>[^<]+)/',
        'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
        'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx'       => '/<li>\s*<a href="(?<img_url>\/\/pictures.dealer.com\/[^"]+)" class="">/',
    'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

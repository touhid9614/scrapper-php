<?php

global $scrapper_configs;

$scrapper_configs['murraykialeth'] = array(
    'entry_points' => array(
            'new'   => 'http://www.murraykia.ca/new-inventory/index.htm',
            'used'  => 'http://www.murraykia.ca/used-inventory/index.htm'
    ),
    'use-proxy' => true,
    'details_start_tag' => '<ul class="inventoryList full">',
    'details_end_tag'   => '<div class="ft">',
    'details_spliter'   => '<div class="item-compare">',
    'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'price'         => '/Price<span class=\'separator\'>:<\/span><\/span><span class="value">(?<price>[^<]+)/',
            'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'data_capture_regx_full' => array(
    ) ,
    'options_start_tag' => '<dt>Options</dt>',
    'options_end_tag'   => '</dd>',
    'options_regx'      => '/<li>[^>]+>(?<option>[^<]+)/',
    'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx'       => '/<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com[^"]+)/',
    'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>\/\/pictures.dealer.com\/j\/[^"]+)"/',
    'auto_texts_regx'   => '/<a href="#" class="dialog xsmall" data-href="[^>]+>\s*(?<auto_text>[^<]+)<\/a>/'
);

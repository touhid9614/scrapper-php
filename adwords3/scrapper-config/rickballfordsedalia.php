<?php

global $scrapper_configs;

$scrapper_configs['rickballfordsedalia'] = array(
    'entry_points' => array(
        'new' => 'https://www.rickballfordsedalia.com/new-inventory/index.htm',
        'used' => 'https://www.rickballfordsedalia.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine( Layout)?:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Color:[^>]+>[^>]+>(?<interior_color>[^<\[]+)/',
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

<?php

global $scrapper_configs;

$scrapper_configs['rousseltoyota'] = array(
    'entry_points' => array(
        'new' => 'https://www.rousseltoyota.com/en/new-car',
        'used' => 'https://www.rousseltoyota.com/en/for-sale/all/used'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/en\/(?:inventory\/)?(?:new|used)/',

    'picture_selectors' => ['.slideshow.cboxElement'],
    'picture_nexts' => ['', '#cboxNext'],
    'picture_prevs' => ['', '#cboxPrevious'],
    'new' => array(
            'details_start_tag' => '<div class="listing-container cf">',
            'details_end_tag'   => '<div class="cz-seo" data-instance="default">',
            'details_spliter'   => '<div class="catalog-vehicle-preview-list box',
        'data_capture_regx' => array(
            'url' => '/<a\s*class="cta\s*btn-even small" href="(?<url>[^"]+)"\s*target/',
            'title' => '/<span class="vehicle-title">(?<title>[^<]+)/',
            'year' => '/<span class="vehicle-title">(?<year>[^\s]+)/',
            'price' => '/Starting at<\/span><span [^>]+>\s*<strong>\s*(?<price>\$[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(
            'make' => '/<div class="title" itemprop="name">\s*(?<make>[^ ]+) (?<model>[^<]+)/',
            'model' => '/<div class="title" itemprop="name">\s*(?<make>[^ ]+) (?<model>[^<]+)/',
            'exterior_color' => '/<div class="color-index">(?<exterior_color>[^<]+)/',
            'url' => '/<meta property="og:url" content="(?<url>[^"]+)"/',
        ),
        'images_regx' => '/<img src="(?<img_url>[^"]+)" id="[^"]+" data-pic-catalog="" itemprop="image"/',

    ),
    'used' => array(
        'details_start_tag' => '<div class="column-content f-l"',
        'details_end_tag' => '<section class="content center full-width">',
        'details_spliter' => '<div class="box inventory-vehicle-preview-list"',
        'data_capture_regx' => array(
            'stock_number' => 'itemprop="sku">#(?<stock_number>[^<]+)/',
            'title' => '/<a href="(?<url>[^"]+)" class="vehicle-title" title="[^"]+">(?<title>(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^<]+))<span\s*class="hide-show">/',
            'year' => '/<a href="(?<url>[^"]+)" class="vehicle-title" title="[^"]+">(?<title>(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^<]+))<span\s*class="hide-show">/',
            'make' => '/<a href="(?<url>[^"]+)" class="vehicle-title" title="[^"]+">(?<title>(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^<]+))<span\s*class="hide-show">/',
            'model' => '/<a href="(?<url>[^"]+)" class="vehicle-title" title="[^"]+">(?<title>(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^<]+))<span\s*class="hide-show">/',
            'price' => '/vehicle-new-price centered">\$(?<price>[^<]+)/',
            'kilometres' => '/(?<kilometres>[0-9 ,]+)\s*KM/',
            'url' => '/<a href="(?<url>[^"]+)"\s*class="vehicle-title"[^>]+>/'
        ),
        'data_capture_regx_full' => array(
            'transmission' => '/<span class="clutch">(?<transmission>[^<]+)/',
            'body_style' => '/Vehicle Type<\/dt>\s*<dd>(?<body_style>[^<]+)/',
            'engine' => '/Cylinders<\/dt>\s*<dd>(?<engine>[ 0-9 a-z A-Z\.]+)/',
            'exterior_color' => '/<dt>Color<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color' => '/<dt>Interior Color<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
        ),
        'next_page_regx' => '/<li class="current\s*test"><a href="[^"]+">[^<]+<\/a><\/li>\s*<li ><a href="(?<next>[^"]+)"/',
        'images_regx' => '/<div id="colorbox-buttom" [^>]+>\s*<img src="(?<img_url>[^"]+)/',
       
    ),
);

<?php

global $scrapper_configs;

$scrapper_configs['macdonaldautogroup'] = array(
    'entry_points' => array(
          'used' => 'http://www.macdonaldautogroup.com/en/for-sale/all/used/',
        'new' => 'http://www.macdonaldautogroup.com/en/new-car/',
      
    ),
    'use-proxy' => true,
    'refine'=>false,
    'vdp_url_regex' => '/\/en\/(?:inventory\/)?(?:new|used)/i',
    'ty_url_regex' => '/\/thank-you/i',
    'ajax_url_match' => '/confirm-availability/',
    'ajax_resp_match' => 'Thank You For Your Inquiry - MacDonald Auto Group',
    'picture_selectors' => ['.image-select li a', '#bxslider-pager a'],
    'picture_nexts' => ['', '#cboxNext'],
    'picture_prevs' => ['', '#cboxPrevious'],
    'new' => array(
        'details_start_tag' => '<ul class="vehicle-title-listing">',
        'details_end_tag' => '<div class="cz-seo" data-instance="default">',
        'details_spliter' => '<div class="catalog-vehicle-preview-list box',
        'data_capture_regx' => array(
            'title' => '/<span class="vehicle-title">(?<title>[^<]+)/',
            'price' => '/<span class="text-vehicle appeal">\$(?<price>[0-9,]+)/',
            'url' => '/<a\s*class="cta\s*btn-even small" href="(?<url>[^"]+)"\s*/'
        ),
        'data_capture_regx_full' => array(
            'make' => '/<div class="title" itemprop="name">\s*(?<make>[^ ]+)\s*(?<model>[^\s*]+)/',
            'model' => '/<div class="title" itemprop="name">\s*(?<make>[^ ]+)\s*(?<model>[^\s*]+)/',
            'year' => '/<div class="subtitle" itemprop="releaseDate">(?<year>[^<]+)/',
            'exterior_color' => '/<div class="color-index">(?<exterior_color>[^<]+)/',
            'interior_color' => '/<li>\s*(?<interior_color>[^ ]+) interior/',
            'transmission' => '/<li>\s*(?<transmission>[^t]+) transmission/'
        ),
        'images_regx' => '/<img src="(?<img_url>[^"]+)" id="[^"]+" data-pic-catalog="" itemprop="image"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    ),
    'used' => array(
        'details_start_tag' => '<div class="column-content f-l"',
        'details_end_tag' => '<section class="content center full-width">',
        'details_spliter' => '<div class="box inventory-vehicle-preview-list"',
        'must_contain_regx' => '/<span class="vehicle-stockno"\s*itemprop="sku">#(?<stock_number>[^<]+)/',
        'data_capture_regx' => array(
            'stock_number' => '/<span class="vehicle-stockno"\s*itemprop="sku">#(?<stock_number>[^<]+)/',
            'title' => '/<a href="(?<url>[^"]+)"\s*itemprop="url"\s*class="vehicle-title"\s*title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+))/',
            'year' => '/<a href="(?<url>[^"]+)"\s*itemprop="url"\s*class="vehicle-title"\s*title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+))/',
            'make' => '/<a href="(?<url>[^"]+)"\s*itemprop="url"\s*class="vehicle-title"\s*title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+))/',
            'model' => '/<a href="(?<url>[^"]+)"\s*itemprop="url"\s*class="vehicle-title"\s*title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+))/',
            'price' => '/itemprop="price">(?<price>[^<]+)/',
            'kilometres' => '/class="vehicle-odo vehicle-clutch clearfix">\s*(?<kilometres>[0-9 ,]+)\s*KM/',
            'url' => '/<a href="(?<url>[^"]+)"\s*itemprop="url"\s*class="vehicle-title"\s*title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+))/'
        ),
        'data_capture_regx_full' => array(
            'transmission' => '/<span class="clutch">(?<transmission>[^<]+)/',
            'body_style' => '/Vehicle Type<\/dt>\s*<dd>(?<body_style>[^<]+)/',
            'engine' => '/Cylinders<\/dt>\s*<dd>(?<engine>[^\n<]+)/',
            'exterior_color' => '/<dt>Color<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color' => '/<dt>Interior Color<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
        ),
        'next_page_regx' => '/<li class="current\s*test"><a href="[^"]+">[^<]+<\/a><\/li>\s*<li ><a href="(?<next>[^"]+)"/',
        'images_regx' => '/<a data-slide-index="[^"]+"\s*href="(?<img_url>[^"]+)"/',
    ),
);

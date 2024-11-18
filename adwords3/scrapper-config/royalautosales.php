<?php

global $scrapper_configs;

$scrapper_configs['royalautosales'] = array(
    'entry_points' => array(
        'used' => 'https://www.royalautosales.ca/used-cars-calgary-ab',
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb'],
    'picture_nexts' => ['.browse.right'],
    'picture_prevs' => ['.browse.left'],
    'details_start_tag' => '<div class="vehicle-page"',
    'details_end_tag' => '<footer class="layout-footer',
    'details_spliter' => '<div class="vehicle"',
    'data_capture_regx' => array(
        'stock_number' => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
        'url' => '/<meta itemprop="url" content="(?<url>[^"]+)/',
        'title' => '/<meta itemprop="name" content="(?<title>[^"]+)/',
        'year' => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
        'make' => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
        'model' => '/<meta itemprop="model" content="(?<model>[^"]+)/',
        'price' => '/<div class="price">(?<price>\$[0-9,]+)/',
        'exterior_color' => '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
        'engine' => '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
        'transmission' => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
        'kilometres' => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/Interior:.*\s*<span class="value">(?<interior_color>[^<]+)/',
    ),
    # Why would someone comment out next page regex!!!!!!!!!!
    'next_page_regx' => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/<li><img src="(?<img_url>[^"]+)" alt="[^"]+" class="img-responsive" itemprop="image"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

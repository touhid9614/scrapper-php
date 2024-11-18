<?php
global $scrapper_configs;
$scrapper_configs["yorkkiacom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.yorkkia.com/new-kia-york-pa',
        'used' => 'https://www.yorkkia.com/used-cars-york-pa',
    ),
    'vdp_url_regex' => '/\/vehicle-details\//i',
    'use-proxy' => true,
     'refine' => false,
    'picture_selectors' => ['.thumb'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<div class="c-vehicles',
    'details_end_tag' => '<div class="top layout-footer',
    'details_spliter' => '<div class="vehicle"',
    'data_capture_regx' => array(
        'stock_number' => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
        'url' => '/<meta itemprop="url" content="(?<url>[^"]+)/',
        'title' => '/<meta itemprop="name" content="(?<title>[^"]+)/',
        'year' => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
        'make' => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
        'model' => '/<meta itemprop="model" content="(?<model>[^"]+)/',
        'price' => '/(?:Final Price:|York Price:)\s*<[^>]+>\s*.*(?<price>\$[0-9,]+)/',
        'exterior_color' => '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
        'transmission' => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
        'kilometres' => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/Interior:<\/strong><\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',
    ),
 //   'next_page_regx' => '/<li id="il-pagination-element-[^"]+" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/<li><img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/'
);

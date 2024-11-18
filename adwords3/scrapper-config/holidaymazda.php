<?php

global $scrapper_configs;
$scrapper_configs["holidaymazda"] = array(
    "entry_points" => array(
        'new' => 'https://www.holidaymazda.com/new-mazda-fond-du-lac-wi',
        'used' => 'https://www.holidaymazda.com/used-cars-fond-du-lac-wi'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|certified|used)-[0-9]{4}-/i',
    
   'picture_selectors' => ['.thumb-preview img'],
    'picture_nexts' => ['.arrow.right'],
    'picture_prevs' => ['.arrow.left'],
    
    'details_start_tag' => '<div class="c-vehicles grid">',
    'details_end_tag' => '<footer class="layout-footer"',
    'details_spliter' => '<div class="vehicle"',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'title' => '/<div class="v-title">\s*<a href="(?<url>[^"]+)">\s*(?<title>[^<]+)/',
        'year' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'make' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'model' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'trim' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'stock_number' => '/stocknumber">(?<stock_number>[^<]+)/',
        'price' => '/<span class="price-value text-bold">(?<price>\$[0-9,]+)/',
        'engine' => '/enginedescription">(?<engine>[^<]+)/',
        'transmission' => '/spec-value-transmission">(?<transmission>[^<]+)/',
        'exterior_color' => '/exteriorcolor">(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/interiorcolor">(?<interior_color>[^<]+)/',
        'kilometres' => '/miles">(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body style:<\/span>\s*<span class="[^>]+>(?<body_style>[^<]+)/',
    ),
    'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/<img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/',
    
);

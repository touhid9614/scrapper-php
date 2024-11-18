<?php

global $scrapper_configs;
$scrapper_configs["holidayautomotive"] = array(
    "entry_points" => array(
       'new' => 'https://www.holidayautomotive.com/new-cars-fond-du-lac-wi',
        'used' => 'https://www.holidayautomotive.com/used-cars-fond-du-lac-wi'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|certified|used)-[0-9]{4}-/i',
    'picture_selectors' => ['.carousel-canvas'],
    'picture_nexts' => ['.arrow.right'],
    'picture_prevs' => ['.arrow.left'],
    'details_start_tag' => '<div class="vehicles">',
    'details_end_tag' => '<div class="inventory-pagination">',
    'details_spliter' => '<div class="vehicle-container">',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'title' => '/<div class="vehicle-title">\s*<a href="(?<url>[^"]+)">\s*(?<title>[^<]+)/',
        'year' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'make' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'model' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'trim' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'stock_number' => '/STOCK:\s*<\/span>\s*(?<stock_number>[^<]+)/',
        'price' => '/<span class="price-value text-bold">[^>]+>\$<\/span>\s*(?<price>[0-9,]+)/',
        'kilometres' => '/MILES: <\/span>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body style:<\/span>\s*<span class="[^>]+>(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/pagination-next.*" href="(?<next>[^"]+)"/',
    'images_regx' => '/<img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/',
);

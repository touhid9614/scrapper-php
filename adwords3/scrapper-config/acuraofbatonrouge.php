<?php

global $scrapper_configs;

$scrapper_configs['acuraofbatonrouge'] = array(
    'entry_points' => array(
        'new' => 'https://www.acuraofbatonrouge.com/new-vehicles/',
        'used' => 'https://www.acuraofbatonrouge.com/used-vehicles/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'ty_url_regex' => '/\/thank-you-for-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['div.visible-sm.visible-xs div.gallery-thumbs div.item img.lazyOwl'],
    'picture_nexts' => ['div#gallery-carousel div.owl-controls.clickable div.owl-buttons div.owl-next'],
    'picture_prevs' => ['div#gallery-carousel div.owl-controls.clickable div.owl-buttons div.owl-prev'],
    'details_start_tag' => '<table class="results_table">',
    'details_end_tag' => '<div id="footer">',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'title' => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'url' => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'stock_number' => '/class="stock-label">Stock #: (?<stock_number>[^<]+)/',
        'price' => '/<span class="price-label">\s*MSRP.*<\/span>\s*<span class="price">\s*(?<price>\$[0-9,]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*<span class="detail-content"> (?<kilometres>[^\n<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

<?php

global $scrapper_configs;

$scrapper_configs['chinookautosales'] = array(
    'entry_points' => array(
        'used' => 'https://www.chinookautosales.com/used-cars'
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/[0-9]{4}-/i',
    'picture_selectors' => ['.slides li img'],
    'picture_nexts' => ['.flex-next'],
    'picture_prevs' => ['.flex-prev'],
    'details_start_tag' => '<div class="main-content-inner',
    'details_end_tag' => '<div id="footer-area">',
    'details_spliter' => '<div class="vehicle search-result-item vehicleList">',
    'data_capture_regx' => array(
        'url' => '/class="col-md-12">\s*<a href="(?<url>[^"]+)/',
        'title' => '/class="vehicleName" style="[^>]+>(?<title>[^<]+)/',
        'engine' => '/Engine:<\/span><span style="[^>]+>(?<engine>[^<]+)/',
        'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'year' => '/class="vehicleName" style="[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/class="vehicleName" style="[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/class="vehicleName" style="[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'stock_number' => '/Stock #:<\/span><span style="[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/<div class="priceVal">(?<price>[^<]+)/',
        'transmission' => '/Transmission:<\/span><span style="[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior:<\/span><span>(?<exterior_color>[^<\[]+)/',
        'body_style' => 'Body Style:<\/span><span style="[^>]+>(?<body_style>[^<]+)',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/Interior Color:<\/span><span>(?<interior_color>[^<\[]+)/',
    ),
    'next_page_regx' => '/class="next page-numbers" href="(?<next>[^"]+)"/',
    'images_regx' => '/<img alt="[^"]+"\s src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

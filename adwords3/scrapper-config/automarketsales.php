<?php

global $scrapper_configs;

$scrapper_configs['automarketsales'] = array(
    'entry_points' => array(
        'used' => 'https://automarketsales.com/used/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/vehicle\//i',
    'required_params' => ['info', 'id'],
    'picture_selectors' => ['.carousel-item img'],
    'picture_nexts' => ['.carousel-control-next'],
    'picture_prevs' => ['.carousel-control-prev'],
    'details_start_tag' => '<div class="vehicles-list-wrap">',
    'details_end_tag' => '<footer>',
    'details_spliter' => '</a>',
    'data_capture_regx' => array(
        'stock_number' => '/stock-info">Stock#[^;]+;(?<stock_number>[^,]+)/',
        'url' => '/vehicle-card2"\s*href="(?<url>[^"]+)/',
        'title' => '/vehicle-info2">\s*<h2>(?<title>[^<]+)<\/h2>\s*<h3[^;]+;(?<price>[0-9,]+)/',
        'price' => '/vehicle-info2">\s*<h2>(?<title>[^<]+)<\/h2>\s*<h3[^;]+;(?<price>[0-9,]+)/',
        'year' => '/vehicle-info2">\s*<h2>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'make' => '/vehicle-info2">\s*<h2>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model' => '/vehicle-info2">\s*<h2>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'kilometres' => '/fa fa-tachometer"[^>]+><\/i>[^\;]+;[^\;]+;(?<kilometres>[0-9,]+ Kms)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/Transmission:<\/strong><\/td><td>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/strong><\/td><td>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:<\/strong><\/td><td>(?<interior_color>[^<]+)/',
        'body_style' => '/Body Style:<\/strong><\/td><td>(?<body_style>[^<]+)/',
        'engine' => '/Engine:<\/strong><\/td><td>(?<engine>[^<]+)/',
        'trim' => '/Trim:<\/strong><\/td><td>(?<trim>[^<]+)/',
           'vin' => '/VIN:[^>]+>[^>]+>[^>]+>(?<vin>[^<]+)/',
    ),
    'next_page_regx' => '/page-item active"><a class="[^"]+" href="[^"]+">[^<]+<\/a><\/li><li class="[^>]+><a class="page-link" href="(?<next>[^"]+)/',
    'images_regx' => '/#vehicleImagesCarousel"[^>]+><img src="(?<img_url>[^"]+)/'
);

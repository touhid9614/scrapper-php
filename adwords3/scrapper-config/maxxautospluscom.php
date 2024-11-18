<?php

global $scrapper_configs;
$scrapper_configs["maxxautospluscom"] = array(
    'entry_points' => array(
        'used' => 'https://www.maxxautosplus.com/inventory?type=used'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide',],
    'picture_nexts' => ['.mz-button.mz-button-next'],
    'picture_prevs' => ['.mz-button.mz-button-prev'],
    'details_start_tag' => '<div class="srp-vehicle-container" >',
    'details_end_tag' => '<footer id="footer"',
    'details_spliter' => '<div class="row srp-vehicle" itemprop="offers"',
    'data_capture_regx' => array(
        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'stock_number' => '/Stock:<\/span>\s*<span>(?<stock_number>[^<]+)/',
        'price' => '/itemprop=\'price\' content=\'(?<price>[0-9]+)/',
        'exterior_color' => '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/current\'><a[^>]+>[0-9]<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
     'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    
);

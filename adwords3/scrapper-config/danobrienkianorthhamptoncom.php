<?php

global $scrapper_configs;

$scrapper_configs['danobrienkianorthhamptoncom'] = array(
    'entry_points' => array(
        'new' => 'https://www.danobrienkianorthhampton.com/inventory?type=new',
        'used' => 'https://www.danobrienkianorthhampton.com/inventory?type=used'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts' => ['button.slick-next'],
    'picture_prevs' => ['button.slick-prev'],
    'details_start_tag' => '<div class="srp-vehicle-container" >',
    'details_end_tag' => '<div class="footer">',
    'details_spliter' => '<div class="row srp-vehicle" itemprop="offers"',
    'data_capture_regx' => array(
        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'stock_number' => '/<div class="column"><span>Stock:<\/span>\s*(?<stock_number>[^<]+)/',
        'vin' => '/VIN[^>]+>\s*(?<vin>[^<]+)<\/div>/',
        'price' => '/itemprop=\'price\'\s*content=\'[^>]+><\/span>(?<price>[^<]+)/',
        'exterior_color' => '/<div class="column"><span>Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/<div class="column"><span>Ext. Color:<\/span>\s*(?<interior_color>[^<]+)/',
        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/current\'><a[^>]+>[0-9]*<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
